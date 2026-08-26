<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Comorbidity;
use App\Models\Consultation;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Recommendation;
use App\Models\TumorEvaluation;
use App\Models\User;
use App\Services\RecommendationGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Populates the app with a realistic-looking patient cohort so the
 * Dashboard, Patients list, and Recommendations pages are never empty
 * in a fresh dev environment. Safe to re-run: everything is guarded
 * by a "does this already exist" check keyed on medical_record_number
 * / doctor license_number, so it won't create duplicates.
 */
class DashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        $doctor = $this->ensureDoctor();
        $this->ensureComorbidities();

        // (name, days_ago patient was registered, patient status,
        //  resectability, ECOG, ca19-9, cholestasis, contraindication,
        //  recommendation outcome: proposed|validated|rejected|rcp)
        $roster = [
            ['Ahmed Benali',     34, 'active',   'locally_advanced', 1, 620, false, false, 'validated'],
            ['Yasmine Cherif',    5, 'active',   'locally_advanced', 1, 180, false, false, 'proposed'],
            ['Karim Ferhat',     33, 'active',   'resectable',       0,  90, false, false, 'proposed'],
            ['Sofia Amrani',      1, 'active',   'metastatic',       2, 740, false, false, 'proposed'],
            ['Mohamed Larbi',     2, 'active',   'locally_advanced', 1, 310, true,  false, 'proposed'],
            ['Nadia Boukhalfa',   3, 'inactive', 'resectable',       0, 120, false, false, 'rcp'],
            ['Leila Haddad',      3, 'active',   'borderline',       1, 260, false, true,  'validated'],
            ['Riad Meziane',     18, 'active',   'resectable',       0,  75, false, false, 'validated'],
            ['Amel Kaci',        21, 'inactive', 'metastatic',       3, 890, false, false, 'rejected'],
            ['Djamel Saadi',     40, 'active',   'borderline',       1, 410, false, false, 'validated'],
            ['Nour Belkacem',     9, 'active',   'resectable',       0, 105, false, false, 'proposed'],
            ['Warda Chaib',      27, 'inactive', 'locally_advanced', 2, 560, true,  true,  'rejected'],
        ];

        $activityBacklog = [];

        foreach ($roster as [$name, $daysAgo, $status, $resectability, $ecog, $ca199, $cholestasis, $contraindication, $outcome]) {
            [$first, $last] = array_pad(explode(' ', $name, 2), 2, '');

            $registeredAt = now()->subDays($daysAgo)->subHours(random_int(1, 20));

            $patient = Patient::firstOrCreate(
                ['medical_record_number' => 'MRN-' . strtoupper(substr(str_replace(' ', '', $last), 0, 3)) . str_pad((string) ($daysAgo + $ecog), 3, '0', STR_PAD_LEFT)],
                [
                    'first_name' => $first,
                    'last_name' => $last,
                    'date_of_birth' => now()->subYears(random_int(45, 78))->subDays(random_int(0, 300)),
                    'sex' => random_int(0, 1) ? 'M' : 'F',
                    'status' => $status,
                    'created_at' => $registeredAt,
                ]
            );

            $activityBacklog[] = [
                'type' => ActivityLog::TYPE_PATIENT_CREATED,
                'message' => "New patient <strong>{$name}</strong> was registered",
                'detail' => 'Added by Dr. ' . $doctor['last_name'],
                'patient_id' => $patient->patient_id,
                'created_at' => $registeredAt,
            ];

            // Only create a clinical consultation + recommendation once
            // per patient (skip if this patient already has one from a
            // previous seeder run).
            if ($patient->consultations()->exists()) {
                continue;
            }

            $consultationAt = $registeredAt->copy()->addDays(random_int(0, min(2, max($daysAgo - 1, 0))));

            $consultation = Consultation::create([
                'patient_id' => $patient->patient_id,
                'doctor_id' => $doctor['user_id'],
                'consultation_date' => $consultationAt,
                'performance_status' => $ecog,
                'clinical_stage' => ucwords(str_replace('_', ' ', $resectability)),
            ]);

            TumorEvaluation::create([
                'consultation_id' => $consultation->consultation_id,
                'resectability' => $resectability,
                'ca19_9_level' => $ca199,
                'cholestasis' => $cholestasis,
                'ca19_9_date' => $consultationAt,
                'surgery_contraindication' => $contraindication,
                'comments' => null,
            ]);

            $activityBacklog[] = [
                'type' => ActivityLog::TYPE_CLINICAL_DATA_UPDATED,
                'message' => "<strong>{$name}</strong>'s clinical data was updated",
                'detail' => 'Stage changed to ' . ucwords(str_replace('_', ' ', $resectability)),
                'patient_id' => $patient->patient_id,
                'created_at' => $consultationAt,
            ];

            $rec = RecommendationGenerator::generateAndStore($consultation);
            $rec->generation_date = $consultationAt;

            $recommendedAt = $consultationAt->copy()->addMinutes(random_int(5, 90));

            $activityBacklog[] = [
                'type' => ActivityLog::TYPE_RECOMMENDATION_GENERATED,
                'message' => "New recommendation generated for <strong>{$name}</strong>",
                'detail' => 'Awaiting clinician review',
                'patient_id' => $patient->patient_id,
                'created_at' => $recommendedAt,
            ];

            if ($outcome !== 'proposed') {
                $statusMap = [
                    'validated' => [Recommendation::STATUS_VALIDATED, 'validated'],
                    'rejected' => [Recommendation::STATUS_REJECTED, 'rejected'],
                    'rcp' => [Recommendation::STATUS_RCP, 'sent to RCP'],
                ];
                [$statusValue, $label] = $statusMap[$outcome];

                $rec->status = $statusValue;

                $decidedAt = $recommendedAt->copy()->addHours(random_int(1, 30));

                $activityBacklog[] = [
                    'type' => ActivityLog::TYPE_RECOMMENDATION_STATUS_CHANGED,
                    'message' => "<strong>{$name}</strong>'s recommendation was {$label}",
                    'detail' => null,
                    'patient_id' => $patient->patient_id,
                    'created_at' => $decidedAt,
                ];
            }

            $rec->save();

            // Status-change activity for the two patients seeded as
            // 'inactive' — mirrors what PatientController::update logs.
            if ($status === 'inactive') {
                $activityBacklog[] = [
                    'type' => ActivityLog::TYPE_STATUS_CHANGED,
                    'message' => "<strong>{$name}</strong>'s status changed to Inactive",
                    'detail' => 'Previously Active',
                    'patient_id' => $patient->patient_id,
                    'created_at' => $registeredAt->copy()->addDays(random_int(1, max($daysAgo - 1, 1))),
                ];
            }
        }

        // Write the backlog in chronological order so auto-increment ids
        // roughly follow created_at, then let ActivityLog::log's default
        // ordering (created_at desc) do the rest at render time.
        usort($activityBacklog, fn ($a, $b) => $a['created_at'] <=> $b['created_at']);

        foreach ($activityBacklog as $entry) {
            if (ActivityLog::where('patient_id', $entry['patient_id'])
                ->where('type', $entry['type'])
                ->where('message', $entry['message'])
                ->exists()) {
                continue;
            }

            ActivityLog::create([
                'type' => $entry['type'],
                'message' => $entry['message'],
                'detail' => $entry['detail'],
                'patient_id' => $entry['patient_id'],
                'user_id' => $doctor['user_id'],
                'created_at' => $entry['created_at'],
            ]);
        }
    }

    /**
     * @return array{user_id:int, last_name:string}
     */
    private function ensureDoctor(): array
    {
        $doctor = Doctor::query()->first();

        if ($doctor) {
            return ['user_id' => $doctor->user_id, 'last_name' => $doctor->user->last_name ?? 'Taieb'];
        }

        $user = User::create([
            'first_name' => 'Amina',
            'last_name' => 'Taieb',
            'email' => 'dr.taieb@pdac-cdss.local',
            'password' => Hash::make('password'),
            'active' => true,
            'created_at' => now()->subDays(60),
        ]);

        Doctor::create([
            'user_id' => $user->user_id,
            'license_number' => 'DZ-ONC-' . str_pad((string) $user->user_id, 5, '0', STR_PAD_LEFT),
            'specialty' => 'Oncology',
        ]);

        return ['user_id' => $user->user_id, 'last_name' => 'Taieb'];
    }

    private function ensureComorbidities(): void
    {
        if (Comorbidity::query()->exists()) {
            return;
        }

        foreach ([
            ['label' => 'Type 2 Diabetes', 'type' => 'metabolic'],
            ['label' => 'Cardiac history', 'type' => 'cardiovascular'],
            ['label' => 'Renal insufficiency', 'type' => 'renal'],
            ['label' => 'Hypertension', 'type' => 'cardiovascular'],
        ] as $row) {
            Comorbidity::create($row);
        }
    }
}
