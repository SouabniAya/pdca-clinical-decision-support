<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Recommendation;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');
        $doctorId = $request->query('doctor');

        $stats = [
            'total_patients'         => Patient::count(),
            'total_recommendations'  => Recommendation::count(),
            'total_consultations'    => Consultation::count(),
            'total_conflicts'        => Recommendation::where('conflict', true)->count(),
        ];

        $doctors = Doctor::with('user')->get()->map(function ($doctor) {
            $user = $doctor->user;
            return [
                'id'   => $doctor->user_id,
                'name' => $user ? trim($user->first_name . ' ' . $user->last_name) : 'Unknown',
            ];
        });

        $reports = Report::with('generatedBy')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id'           => $r->report_id,
                'name'         => $r->name,
                'type'         => ucfirst($r->type),
                'date_from'    => $r->date_from,
                'date_to'      => $r->date_to,
                'generated_by' => $r->generatedBy
                    ? trim($r->generatedBy->first_name . ' ' . $r->generatedBy->last_name)
                    : 'System',
                'created_at'   => $r->created_at,
                'status'       => $r->status,
            ]);

        return view('patients.reports', [
            'stats'   => $stats,
            'doctors' => $doctors,
            'reports' => $reports,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to'   => $dateTo,
                'doctor'    => $doctorId,
            ],
        ]);
    }

    /**
     * Export manuel déclenché par le bouton "Export".
     * Génère le CSV, l'enregistre sur disque, log une ligne dans `report`,
     * puis le télécharge immédiatement.
     */
    public function export(Request $request, string $type): StreamedResponse
    {
        $type = strtolower($type);
        $allowed = ['patients', 'recommendations', 'consultations', 'audit'];

        if (!in_array($type, $allowed)) {
            abort(404, 'Unknown report type.');
        }

        $dateFrom = $request->query('date_from');
        $dateTo   = $request->query('date_to');
        $doctorId = $request->query('doctor');

        $csv = $this->buildCsv($type, $dateFrom, $dateTo, $doctorId);

        $filename    = $type . '_report_' . now()->format('Y-m-d_His') . '.csv';
        $storagePath = 'reports/' . $filename;
        Storage::put($storagePath, $csv);

        Report::create([
            'name'         => ucfirst($type) . ' report – ' . now()->format('Y-m-d H:i'),
            'type'         => $type,
            'date_from'    => $dateFrom,
            'date_to'      => $dateTo,
            'file_path'    => $storagePath,
            'generated_by' => auth()->id(),
            'status'       => 'completed',
            'created_at'   => now(),
        ]);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Télécharge un rapport déjà généré (manuel ou quotidien) depuis l'historique.
     */
    public function download(string $reportId)
    {
        $report = Report::findOrFail($reportId);

        if (!$report->file_path || !Storage::exists($report->file_path)) {
            abort(404, 'Report file not found.');
        }

        return Storage::download($report->file_path, basename($report->file_path));
    }

    private function buildCsv(string $type, ?string $dateFrom, ?string $dateTo, ?string $doctorId): string
    {
        $handle = fopen('php://temp', 'w+');

        switch ($type) {
            case 'patients':
                fputcsv($handle, ['Patient ID', 'First Name', 'Last Name', 'Date of Birth', 'Sex', 'MRN', 'Status', 'Created At']);
                $query = Patient::orderBy('patient_id');
                if ($dateFrom) $query->whereDate('created_at', '>=', $dateFrom);
                if ($dateTo)   $query->whereDate('created_at', '<=', $dateTo);
                $query->chunk(200, function ($patients) use ($handle) {
                    foreach ($patients as $p) {
                        fputcsv($handle, [
                            $p->patient_id, $p->first_name, $p->last_name, $p->date_of_birth,
                            $p->sex, $p->medical_record_number, $p->status, $p->created_at,
                        ]);
                    }
                });
                break;

            case 'recommendations':
                fputcsv($handle, ['Recommendation ID', 'Consultation ID', 'Rule ID', 'Status', 'Grade', 'Conflict', 'Generation Date']);
                $query = Recommendation::orderBy('recommendation_id');
                if ($dateFrom) $query->whereDate('generation_date', '>=', $dateFrom);
                if ($dateTo)   $query->whereDate('generation_date', '<=', $dateTo);
                if ($doctorId) {
                    $query->whereHas('consultation', function ($q) use ($doctorId) {
                        $q->where('doctor_id', $doctorId);
                    });
                }
                $query->chunk(200, function ($recs) use ($handle) {
                    foreach ($recs as $r) {
                        fputcsv($handle, [
                            $r->recommendation_id, $r->consultation_id, $r->rule_id,
                            $r->status, $r->grade, $r->conflict ? 'Yes' : 'No', $r->generation_date,
                        ]);
                    }
                });
                break;

            case 'consultations':
                fputcsv($handle, ['Consultation ID', 'Patient ID', 'Doctor ID', 'Consultation Date', 'Performance Status', 'Clinical Stage']);
                $query = Consultation::orderBy('consultation_id');
                if ($dateFrom) $query->whereDate('consultation_date', '>=', $dateFrom);
                if ($dateTo)   $query->whereDate('consultation_date', '<=', $dateTo);
                if ($doctorId) $query->where('doctor_id', $doctorId);
                $query->chunk(200, function ($cons) use ($handle) {
                    foreach ($cons as $c) {
                        fputcsv($handle, [
                            $c->consultation_id, $c->patient_id, $c->doctor_id,
                            $c->consultation_date, $c->performance_status, $c->clinical_stage,
                        ]);
                    }
                });
                break;

            case 'audit':
                fputcsv($handle, ['Activity ID', 'Type', 'Message', 'Patient ID', 'User ID', 'Created At']);
                $query = DB::table('activity_log')->orderBy('created_at', 'desc');
                if ($dateFrom) $query->whereDate('created_at', '>=', $dateFrom);
                if ($dateTo)   $query->whereDate('created_at', '<=', $dateTo);
                if ($doctorId) $query->where('user_id', $doctorId);
                $query->chunk(200, function ($logs) use ($handle) {
                    foreach ($logs as $log) {
                        fputcsv($handle, [
                            $log->activity_id, $log->type, strip_tags($log->message),
                            $log->patient_id, $log->user_id, $log->created_at,
                        ]);
                    }
                });
                break;
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $csv;
    }
}