<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    // TODO: replace with real authentication logic (e.g. Auth::attempt)
    return back()->withErrors(['id' => 'Invalid credentials.']);
})->name('login.store');

Route::get('/password/forgot', function () {
    return 'TODO: forgot password page';
})->name('password.request');

Route::get('/auth/google', function () {
    // TODO: wire up Socialite (or your OAuth provider) here
    return 'TODO: Google OAuth redirect';
})->name('auth.google');
Route::get('/patients', function () {
    return view('patients.index');
})->name('patients.index');
Route::get('/patients/{id}', function ($id) {
    return view('patients.details', ['id' => $id]);
})->name('patients.show');
Route::get('/patients/{id}/clinical-explanation', function ($id) {
    return view('patients.clinical-explanation');
})->name('patients.clinical-explanation');
Route::get('/patients/{id}/clinical-data', function ($id) {
    // TODO: replace with real patient / evaluation / comorbidity lookups
    $patient = ['id' => $id, 'name' => 'Patient #' . $id];
    $comorbidities = [
        ['id' => 1, 'label' => 'Diabetes mellitus'],
        ['id' => 2, 'label' => 'Hypertension'],
        ['id' => 3, 'label' => 'Chronic kidney disease'],
        ['id' => 4, 'label' => 'Cardiovascular disease'],
    ];
    return view('patients.clinical-form', [
        'patient' => $patient,
        'comorbidities' => $comorbidities,
        'evaluation' => null,
        'selectedComorbidities' => [],
    ]);
})->name('clinical-data.edit');
Route::match(['put', 'post'], '/patients/{id}/clinical-data', function ($id) {
    // TODO: validate input (RF-04, RF-05, RF-07) and persist via the Model layer (EVALUATION_TUMORALE, CONSULTATION_COMORBIDITE)
    return redirect('/patients/' . $id);
})->name('clinical-data.store');
Route::get('/clinical-rules', function () {
    return view('patients.rules');
})->name('rules.index');
Route::get('/patients/details', function () {
    return view('patients.details');
})->name('patients.details');
Route::get('/help', function () {
    return view('pages.help');
})->name('help');
Route::get('/dashboard', function () {
    return view('patients.dashboard');
})->name('dashboard');
Route::get('/settings', function () {
    return view('patients.settings');
})->name('settings');

Route::get('/users', function () {
    $users = [
        ['id' => 'U00128', 'name' => 'Ahmed Benali', 'email' => 'na_benali@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
        ['id' => 'U00129', 'name' => 'Sarah Kaci', 'email' => 's_kaci@esi.dz', 'status' => 'Active', 'role' => 'Doctor'],
        ['id' => 'U00130', 'name' => 'Yacine Meziane', 'email' => 'y_meziane@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
        ['id' => 'U00131', 'name' => 'Lina Belkacem', 'email' => 'l_belkacem@esi.dz', 'status' => 'Inactive', 'role' => 'Administrator'],
        ['id' => 'U00132', 'name' => 'Karim Zerouali', 'email' => 'k_zerouali@esi.dz', 'status' => 'Active', 'role' => 'Doctor'],
        ['id' => 'U00133', 'name' => 'Nadia Bouzid', 'email' => 'n_bouzid@esi.dz', 'status' => 'Active', 'role' => 'Nurse'],
    ];
    return view('users.index', ['users' => $users]);
})->name('users.index');

use App\Services\PdacRuleEngine;

function pdacRecommendationsDemoData(): array
{
    return [
        [
            'id' => 1,
            'patient_id' => 'P00128',
            'patient_name' => 'Ahmed Benali',
            'dossier_id' => 'PDAC-0128',
            'age' => 62,
            'doctor' => 'Dr. Taieb',
            'consultation_date' => '10/08/2026',
            'updated_at' => '10/08/2026',
            'status' => 'Pending Review',
            'clinical' => [
                'resectability' => 'resectable',
                'performance_status' => 0,
                'ca19_9' => 120,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 62,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
        [
            'id' => 2,
            'patient_id' => 'P00142',
            'patient_name' => 'B. Kaci',
            'dossier_id' => 'PDAC-0142',
            'age' => 59,
            'doctor' => 'Dr. A. Souabni',
            'consultation_date' => '14/08/2026',
            'updated_at' => '14/08/2026',
            'status' => 'Pending Review',
            'clinical' => [
                'resectability' => 'resectable',
                'performance_status' => 1,
                'ca19_9' => 480,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 59,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
        [
            'id' => 3,
            'patient_id' => 'P00155',
            'patient_name' => 'Yacine Meziane',
            'dossier_id' => 'PDAC-0155',
            'age' => 54,
            'doctor' => 'Dr. Taieb',
            'consultation_date' => '05/08/2026',
            'updated_at' => '06/08/2026',
            'status' => 'Reviewed',
            'clinical' => [
                'resectability' => 'borderline',
                'performance_status' => 1,
                'ca19_9' => 300,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 54,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
        [
            'id' => 4,
            'patient_id' => 'P00161',
            'patient_name' => 'Lina Belkacem',
            'dossier_id' => 'PDAC-0161',
            'age' => 71,
            'doctor' => 'Dr. Souabni',
            'consultation_date' => '02/08/2026',
            'updated_at' => '02/08/2026',
            'status' => 'Pending Review',
            'clinical' => [
                'resectability' => 'locally_advanced',
                'performance_status' => 0,
                'ca19_9' => 610,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 71,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
        [
            'id' => 5,
            'patient_id' => 'P00173',
            'patient_name' => 'Karim Zerouali',
            'dossier_id' => 'PDAC-0173',
            'age' => 66,
            'doctor' => 'Dr. Taieb',
            'consultation_date' => '30/07/2026',
            'updated_at' => '31/07/2026',
            'status' => 'Reviewed',
            'clinical' => [
                'resectability' => 'locally_advanced',
                'performance_status' => 2,
                'ca19_9' => 540,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 66,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
        [
            'id' => 6,
            'patient_id' => 'P00188',
            'patient_name' => 'Nadia Bouzid',
            'dossier_id' => 'PDAC-0188',
            'age' => 68,
            'doctor' => 'Dr. Souabni',
            'consultation_date' => '28/07/2026',
            'updated_at' => '29/07/2026',
            'status' => 'Pending Review',
            'clinical' => [
                'resectability' => 'metastatic',
                'performance_status' => 1,
                'ca19_9' => 890,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 68,
                'brca_mutation' => true,
                'stable_16w_on_platinum' => true,
            ],
        ],
        [
            'id' => 7,
            'patient_id' => 'P00190',
            'patient_name' => 'Mohamed Larbi',
            'dossier_id' => 'PDAC-0190',
            'age' => 77,
            'doctor' => 'Dr. Taieb',
            'consultation_date' => '20/07/2026',
            'updated_at' => '22/07/2026',
            'status' => 'Reviewed',
            'clinical' => [
                'resectability' => 'metastatic',
                'performance_status' => 3,
                'ca19_9' => 210,
                'cholestasis' => false,
                'surgical_contraindication' => false,
                'severe_comorbidities' => false,
                'bilirubin_elevated' => false,
                'age' => 77,
                'brca_mutation' => false,
                'stable_16w_on_platinum' => false,
            ],
        ],
    ];
}

function pdacStageLabel(array $clinical, ?string $abcType): string
{
    $labels = [
        'resectable' => 'Resectable',
        'borderline' => 'Borderline',
        'locally_advanced' => 'Locally Advanced',
        'metastatic' => 'Metastatic',
    ];
    $label = $labels[$clinical['resectability']] ?? $clinical['resectability'];
    if ($clinical['resectability'] === 'resectable' && $abcType) {
        $label .= " — Type {$abcType}";
    }
    return $label;
}

Route::get('/recommendations', function () {
    $data = pdacRecommendationsDemoData();

    $recommendations = array_map(function ($rec) {
        $result = PdacRuleEngine::evaluate($rec['clinical']);
        $rec['stage_label'] = pdacStageLabel($rec['clinical'], $result['abc_type']);
        return $rec;
    }, $data);

    $pendingCount = count(array_filter($recommendations, fn ($r) => $r['status'] === 'Pending Review'));

    return view('recommendations.index', [
        'recommendations' => $recommendations,
        'pendingCount' => $pendingCount,
    ]);
})->name('recommendations.index');

Route::get('/recommendations/{id}', function ($id) {
    $data = pdacRecommendationsDemoData();
    $rec = collect($data)->firstWhere('id', (int) $id);

    if (! $rec) {
        abort(404);
    }

    $result = PdacRuleEngine::evaluate($rec['clinical']);
    $rec['stage_label'] = pdacStageLabel($rec['clinical'], $result['abc_type']);

    return view('recommendations.show', [
        'rec' => $rec,
        'result' => $result,
    ]);
})->name('recommendations.show');

// Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
// Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
// Route::put('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.preferences.update');
// TODO: uncomment once App\Http\Controllers\SettingsController exists