<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Consultation;
use App\Models\Recommendation;
use App\Services\RecommendationGenerator;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    /**
     * List every recommendation currently in the system, most recent first.
     */
   public function index(Request $request)
{
    $filters = [
        'search' => $request->input('search'),
        'status' => $request->input('status'),
        'stage'  => $request->input('stage'),
    ];

    $query = Recommendation::with(['consultation.patient', 'consultation.doctor.user', 'consultation.tumorEvaluation']);

    if ($filters['status']) {
        $query->where('status', $filters['status']);
    }

    if ($filters['stage']) {
        $query->whereHas('consultation.tumorEvaluation', function ($q) use ($filters) {
            $q->where('resectability', $filters['stage']);
        });
    }

    if ($filters['search']) {
        $search = $filters['search'];
        $query->whereHas('consultation.patient', function ($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('medical_record_number', 'like', "%$search%")
              ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%$search%"]);
        });
    }

    $rows = $query->orderByDesc('generation_date')->get();

    $recommendations = $rows->map(function (Recommendation $rec) {
        $patient = $rec->consultation->patient;

        return [
            'id' => $rec->recommendation_id,
            'patient_id' => 'P' . str_pad((string) $patient->patient_id, 5, '0', STR_PAD_LEFT),
            'patient_name' => trim($patient->first_name . ' ' . $patient->last_name),
            'age' => $patient->age,
            'status' => $rec->status_label,
            'stage_label' => $this->stageLabel($rec),
            'updated_at' => optional($rec->generation_date)->format('d/m/Y'),
        ];
    });

    $pendingCount = Recommendation::where('status', Recommendation::STATUS_PROPOSED)->count();
    $totalCount   = Recommendation::count();

    return view('recommendations.index', [
        'recommendations' => $recommendations,
        'pendingCount' => $pendingCount,
        'totalCount' => $totalCount,
        'filters' => $filters,
        'statusOptions' => [
            Recommendation::STATUS_PROPOSED  => 'Proposed',
            Recommendation::STATUS_VALIDATED => 'Validated',
            Recommendation::STATUS_REJECTED  => 'Rejected',
            Recommendation::STATUS_RCP       => 'Sent to RCP',
        ],
        'stageOptions' => [
            'resectable'        => 'Resectable',
            'borderline'        => 'Borderline',
            'locally_advanced'  => 'Locally Advanced',
            'metastatic'        => 'Metastatic',
        ],
    ]);
}

    /**
     * Show the full traceable detail of a single recommendation.
     */
    public function show($id)
    {
        $rec = Recommendation::with([
            'consultation.patient',
            'consultation.doctor.user',
            'consultation.tumorEvaluation',
            'consultation.comorbidities',
            'rcpMeeting',
        ])->findOrFail($id);

        $consultation = $rec->consultation;
        $patient = $consultation->patient;
        $evaluation = $consultation->tumorEvaluation;
        $doctorUser = $consultation->doctor->user ?? null;

        $recData = [
            'id' => $rec->recommendation_id,
            'patient_name' => trim($patient->first_name . ' ' . $patient->last_name),
            'dossier_id' => 'PDAC-' . str_pad((string) $patient->patient_id, 4, '0', STR_PAD_LEFT),
            'age' => $patient->age,
            'doctor' => $doctorUser ? 'Dr. ' . trim($doctorUser->first_name . ' ' . $doctorUser->last_name) : 'Unassigned',
            'consultation_date' => $consultation->consultation_date?->format('d/m/Y'),
            'stage_label' => $this->stageLabel($rec),
            'status' => $rec->status,
            'rcp_meeting_exists' => (bool) $rec->rcpMeeting,
            'clinical' => [
                'performance_status' => $consultation->performance_status,
                'ca19_9' => $evaluation->ca19_9_level,
                'cholestasis' => (bool) $evaluation->cholestasis,
                'bilirubin_elevated' => false,
                'severe_comorbidities' => $consultation->comorbidities->contains(fn ($c) => $c->pivot->severity === 'severe'),
                'surgical_contraindication' => (bool) $evaluation->surgery_contraindication,
            ],
        ];

        $result = [
            'rule_id' => $rec->rule_id,
            'recommendation' => $rec->recommendation_text,
            'justification' => $rec->justification,
            'source' => $rec->source,
            'grade' => $rec->grade,
            'abc_type' => $rec->abc_type,
            'conflict' => $rec->conflict,
            'conflict_reason' => $rec->conflict_reason,
            'transversal_note' => $rec->details['transversal_note'] ?? null,
            'overlay_rule' => $rec->details['overlay_rule'] ?? null,
        ];

        return view('recommendations.show', [
            'rec' => $recData,
            'result' => $result,
        ]);
    }

    /**
     * Generate a fresh recommendation for a consultation that doesn't
     * have one yet (used right after clinical data entry — RF-11).
     */
    public function generate($consultationId)
    {
        $consultation = Consultation::findOrFail($consultationId);

        $rec = RecommendationGenerator::generateAndStore($consultation);

        $patient = $consultation->patient;

        ActivityLog::log(
            ActivityLog::TYPE_RECOMMENDATION_GENERATED,
            'New recommendation generated for <strong>' . e(trim($patient->first_name . ' ' . $patient->last_name)) . '</strong>',
            'Awaiting clinician review',
            $patient->patient_id
        );

        return redirect()
            ->route('recommendations.show', $rec->recommendation_id)
            ->with('success', 'Recommendation generated.');
    }

    /**
     * RF-13 — clinician validates the proposed recommendation.
     */
    public function validateRecommendation($id)
    {
        $rec = Recommendation::with('consultation.patient')->findOrFail($id);
        $rec->status = Recommendation::STATUS_VALIDATED;
        $rec->save();

        $this->logStatusChange($rec, 'Validated');

        return back()->with('success', 'Recommendation validated.');
    }

    /**
     * RF-13 — clinician rejects the proposed recommendation.
     */
    public function reject($id)
    {
        $rec = Recommendation::with('consultation.patient')->findOrFail($id);
        $rec->status = Recommendation::STATUS_REJECTED;
        $rec->save();

        $this->logStatusChange($rec, 'Rejected');

        return back()->with('success', 'Recommendation rejected.');
    }

    /**
     * RF-13 / RF-16 — ambiguous or contested case referred to the
     * multidisciplinary team meeting (RCP).
     */
    public function sendToRcp($id)
    {
        $rec = Recommendation::with('consultation.patient')->findOrFail($id);
        $rec->status = Recommendation::STATUS_RCP;
        $rec->save();

        $this->logStatusChange($rec, 'Sent to RCP');

        return back()->with('success', 'Recommendation sent to RCP.');
    }

    private function logStatusChange(Recommendation $rec, string $newStatusLabel): void
    {
        $patient = $rec->consultation->patient;

        ActivityLog::log(
            ActivityLog::TYPE_RECOMMENDATION_STATUS_CHANGED,
            '<strong>' . e(trim($patient->first_name . ' ' . $patient->last_name)) . "</strong>'s recommendation was " . strtolower($newStatusLabel),
            null,
            $patient->patient_id
        );
    }

    private function stageLabel(Recommendation $rec): string
    {
        $labels = [
            'resectable' => 'Resectable',
            'borderline' => 'Borderline',
            'locally_advanced' => 'Locally Advanced',
            'metastatic' => 'Metastatic',
        ];

        $resectability = $rec->consultation->tumorEvaluation->resectability ?? null;
        $label = $labels[$resectability] ?? ($resectability ?? 'Unknown');

        if ($resectability === 'resectable' && $rec->abc_type) {
            $label .= " — Type {$rec->abc_type}";
        }

        return $label;
    }
}
