<?php

namespace App\Console\Commands;

use App\Models\Patient;
use App\Models\Recommendation;
use App\Models\Report;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateDailyReports extends Command
{
    protected $signature = 'reports:generate-daily';
    protected $description = 'Generate the daily patients report and the daily recommendations report';

    public function handle(): int
    {
        $today = now()->toDateString();

        $this->generatePatientsReport($today);
        $this->generateRecommendationsReport($today);

        $this->info("Daily reports generated for {$today}.");
        return self::SUCCESS;
    }

    private function generatePatientsReport(string $today): void
    {
        $patients = Patient::whereDate('created_at', $today)->orderBy('patient_id')->get();

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['Patient ID', 'First Name', 'Last Name', 'Date of Birth', 'Sex', 'MRN', 'Status', 'Created At']);

        foreach ($patients as $p) {
            fputcsv($handle, [
                $p->patient_id, $p->first_name, $p->last_name, $p->date_of_birth,
                $p->sex, $p->medical_record_number, $p->status, $p->created_at,
            ]);
        }

        rewind($handle);
        $filename = "reports/patients_{$today}.csv";
        Storage::put($filename, stream_get_contents($handle));
        fclose($handle);

        Report::create([
            'name'         => "Daily patients report – {$today}",
            'type'         => 'patients',
            'date_from'    => $today,
            'date_to'      => $today,
            'file_path'    => $filename,
            'generated_by' => null, // généré par le système, pas un utilisateur
            'status'       => 'completed',
            'created_at'   => now(),
        ]);
    }

    private function generateRecommendationsReport(string $today): void
    {
        $recommendations = Recommendation::whereDate('generation_date', $today)->orderBy('recommendation_id')->get();

        $handle = fopen('php://temp', 'w+');
        fputcsv($handle, ['Recommendation ID', 'Consultation ID', 'Rule ID', 'Status', 'Grade', 'Conflict', 'Generation Date']);

        foreach ($recommendations as $r) {
            fputcsv($handle, [
                $r->recommendation_id, $r->consultation_id, $r->rule_id,
                $r->status, $r->grade, $r->conflict ? 'Yes' : 'No', $r->generation_date,
            ]);
        }

        rewind($handle);
        $filename = "reports/recommendations_{$today}.csv";
        Storage::put($filename, stream_get_contents($handle));
        fclose($handle);

        Report::create([
            'name'         => "Daily recommendations report – {$today}",
            'type'         => 'recommendations',
            'date_from'    => $today,
            'date_to'      => $today,
            'file_path'    => $filename,
            'generated_by' => null,
            'status'       => 'completed',
            'created_at'   => now(),
        ]);
    }
}