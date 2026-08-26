<?php

namespace App\Http\Controllers;

use App\Models\Comorbidity;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TumorEvaluation;
use App\Services\RecommendationGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicalDataController extends Controller
{
    /**
     * Show the blank clinical data form for a patient.
     * Every submission creates a NEW consultation + evaluation,
     * so this form is always blank (no pre-filled $evaluation).
     */
    public function edit($id)
    {
        $patientModel = Patient::findOrFail($id);

        $patient = [
            'id' => $patientModel->patient_id,
            'name' => trim($patientModel->first_name . ' ' . $patientModel->last_name),
        ];

        $comorbidities = Comorbidity::orderBy('label')->get()->map(function ($c) {
            return ['id' => $c->comorbidity_id, 'label' => $c->label];
        })->all();

        return view('patients.clinical-form', [
            'patient' => $patient,
            'comorbidities' => $comorbidities,
            'evaluation' => null,
            'selectedComorbidities' => [],
        ]);
    }

    /**
     * Persist a new consultation + tumor evaluation + comorbidities
     * for the given patient.
     */
    public function store(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->validate([
            'consultation_date' => 'required|date',
            'performance_status' => 'required|integer|between:0,4',
            'clinical_stage' => 'nullable|string|max:50',

            'resectability' => 'required|in:resectable,borderline,locally_advanced,metastatic',
            'ca19_9' => 'nullable|numeric|min:0',
            'ca19_9_date' => 'nullable|date',
            'cholestasis' => 'nullable|boolean',
            'surgical_contraindication' => 'nullable|boolean',
            'comment' => 'nullable|string',

            'comorbidities' => 'array',
            'comorbidities.*' => 'exists:comorbidity,comorbidity_id',
            'severity' => 'array',
            'severity.*' => 'nullable|in:mild,moderate,severe',
        ]);

        // TODO: replace with Auth::id() once the authentication module is wired.
        // For now we default to the first doctor on record.
        $doctorId = Doctor::query()->value('user_id');

        if (! $doctorId) {
            return back()
                ->withInput()
                ->withErrors(['doctor' => 'No doctor found in the system. Please create a doctor record first.']);
        }

        $consultationId = null;

        DB::transaction(function () use ($data, $patient, $doctorId, $request, &$consultationId) {
            $consultation = Consultation::create([
                'patient_id' => $patient->patient_id,
                'doctor_id' => $doctorId,
                'consultation_date' => $data['consultation_date'],
                'performance_status' => $data['performance_status'],
                'clinical_stage' => $data['clinical_stage'] ?? null,
            ]);

            TumorEvaluation::create([
                'consultation_id' => $consultation->consultation_id,
                'resectability' => $data['resectability'],
                'ca19_9_level' => $data['ca19_9'] ?? null,
                'cholestasis' => $request->boolean('cholestasis'),
                'ca19_9_date' => $data['ca19_9_date'] ?? null,
                'surgery_contraindication' => $request->boolean('surgical_contraindication'),
                'comments' => $data['comment'] ?? null,
            ]);

            $comorbidityIds = $data['comorbidities'] ?? [];
            $severities = $request->input('severity', []);

            $pivotData = [];
            foreach ($comorbidityIds as $comorbidityId) {
                $pivotData[$comorbidityId] = [
                    'severity' => $severities[$comorbidityId] ?? null,
                ];
            }

            if (! empty($pivotData)) {
                $consultation->comorbidities()->attach($pivotData);
            }

            $consultationId = $consultation->consultation_id;
        });

        // RF-11 — the system automatically proposes a recommendation
        // as soon as the clinical evaluation has been entered.
        $consultation = Consultation::findOrFail($consultationId);
        $recommendation = RecommendationGenerator::generateAndStore($consultation);

        return redirect()
            ->route('recommendations.show', $recommendation->recommendation_id)
            ->with('success', 'Clinical data saved and recommendation generated.');
    }
}
