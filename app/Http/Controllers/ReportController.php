<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Recommendation;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_patients'         => Patient::count(),
            'total_recommendations'  => Recommendation::count(),
            'total_consultations'    => Consultation::count(),
            'total_conflicts'        => Recommendation::where('conflict', true)->count(),
        ];

        $reports = Report::with('generatedBy')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id'           => $r->report_id,
                'name'         => $r->name,
                'type'         => ucfirst($r->type),
                'generated_by' => $r->generatedBy
                    ? trim($r->generatedBy->first_name . ' ' . $r->generatedBy->last_name)
                    : 'System',
                'created_at'   => $r->created_at,
                'status'       => $r->status,
            ]);

        return view('patients.reports', [
            'stats'   => $stats,
            'reports' => $reports,
        ]);
    }

    /**
     * Export manuel déclenché par le bouton "Export".
     * Génère le CSV, l'enregistre sur disque, log une ligne dans `report`,
     * puis le télécharge immédiatement.
     *
     * Patients et Recommendations exportent toujours la totalité des
     * données du système (pas de filtrage par plage de dates).
     */
    public function export(Request $request, string $type): StreamedResponse
    {
        $type = strtolower($type);
        $allowed = ['patients', 'recommendations', 'consultations', 'audit'];

        if (!in_array($type, $allowed)) {
            abort(404, 'Unknown report type.');
        }

        $csv = $this->buildCsv($type);

        $filename = $type . '_report_' . now()->format('Y-m-d_His') . '.csv';

        Report::create([
            'name'         => ucfirst($type) . ' report – ' . now()->format('Y-m-d H:i'),
            'type'         => $type,
            'generated_by' => auth()->id(),
            'status'       => 'completed',
            'created_at'   => now(),
        ]);

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Télécharge un rapport depuis l'historique.
     * Le CSV est toujours régénéré à partir des données actuelles de la
     * base — jamais servi depuis un fichier figé sur disque — pour que
     * le contenu reflète l'état réel du système au moment du téléchargement,
     * même si le rapport a été "généré" (loggé) il y a plusieurs jours.
     */
    public function download(string $reportId)
    {
        $report = Report::findOrFail($reportId);

        $csv = $this->buildCsv($report->type);

        $filename = $report->type . '_report_' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    private function buildCsv(string $type): string
    {
        $handle = fopen('php://temp', 'w+');

        switch ($type) {
            case 'patients':
                fputcsv($handle, ['Patient ID', 'First Name', 'Last Name', 'Date of Birth', 'Sex', 'MRN', 'Status', 'Created At']);
                // Rapport toujours complet : la totalité des patients du système.
                Patient::orderBy('patient_id')->chunk(200, function ($patients) use ($handle) {
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
                // Rapport toujours complet : la totalité des recommandations du système.
                Recommendation::orderBy('recommendation_id')->chunk(200, function ($recs) use ($handle) {
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
                Consultation::orderBy('consultation_id')->chunk(200, function ($cons) use ($handle) {
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
                DB::table('activity_log')->orderBy('created_at', 'desc')->chunk(200, function ($logs) use ($handle) {
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