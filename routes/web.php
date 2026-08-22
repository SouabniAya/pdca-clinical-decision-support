<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ClinicalDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\SettingsController;

use App\Services\PdacRuleEngine;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/


// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// Login submission
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');


// Forgot password
Route::get('/password/forgot', function () {
    return 'TODO: forgot password page';
})->name('password.request');


// Google authentication
Route::get('/auth/google', function () {
    // TODO: wire up Socialite / Google OAuth
    return 'TODO: Google OAuth redirect';
})->name('auth.google');


/*
|--------------------------------------------------------------------------
| Patients
|--------------------------------------------------------------------------
*/


Route::resource('patients', PatientController::class);


// Clinical explanation
Route::get(
    '/patients/{id}/clinical-explanation',
    function ($id) {
        return view('patients.clinical-explanation');
    }
)->name('patients.clinical-explanation');


// Clinical data - edit
Route::get(
    '/patients/{id}/clinical-data',
    [ClinicalDataController::class, 'edit']
)->name('clinical-data.edit');


// Clinical data - store/update
Route::match(
    ['put', 'post'],
    '/patients/{id}/clinical-data',
    [ClinicalDataController::class, 'store']
)->name('clinical-data.store');


/*
|--------------------------------------------------------------------------
| Clinical Rules
|--------------------------------------------------------------------------
*/


Route::get('/clinical-rules', function () {
    return view('patients.rules');
})->name('rules.index');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/


Route::get('/dashboard', function () {
    return view('patients.dashboard');
})->name('dashboard');


/*
|--------------------------------------------------------------------------
| Help
|--------------------------------------------------------------------------
*/


Route::get('/help', function () {
    return view('pages.help');
})->name('help');


/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/


Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::get('/users/{id}', [UserController::class, 'show'])
    ->name('users.show');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])
    ->name('users.edit');

Route::put('/users/{id}', [UserController::class, 'update'])
    ->name('users.update');

Route::delete('/users/{id}', [UserController::class, 'destroy'])
    ->name('users.destroy');


/*
|--------------------------------------------------------------------------
| Doctor
|--------------------------------------------------------------------------
*/


Route::get('/doctor/profile', [DoctorProfileController::class, 'show'])
    ->name('doctor.profile');


/*
|--------------------------------------------------------------------------
| Recommendations
|--------------------------------------------------------------------------
*/


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


function pdacStageLabel(
    array $clinical,
    ?string $abcType
): string {
    $labels = [
        'resectable' => 'Resectable',
        'borderline' => 'Borderline',
        'locally_advanced' => 'Locally Advanced',
        'metastatic' => 'Metastatic',
    ];

    $label = $labels[$clinical['resectability']]
        ?? $clinical['resectability'];

    if (
        $clinical['resectability'] === 'resectable'
        && $abcType
    ) {
        $label .= " — Type {$abcType}";
    }

    return $label;
}


Route::get('/recommendations', function () {

    $data = pdacRecommendationsDemoData();

    $recommendations = array_map(function ($rec) {

        $result = PdacRuleEngine::evaluate(
            $rec['clinical']
        );

        $rec['stage_label'] = pdacStageLabel(
            $rec['clinical'],
            $result['abc_type']
        );

        return $rec;

    }, $data);


    $pendingCount = count(
        array_filter(
            $recommendations,
            fn ($r) => $r['status'] === 'Pending Review'
        )
    );


    return view('recommendations.index', [
        'recommendations' => $recommendations,
        'pendingCount' => $pendingCount,
    ]);

})->name('recommendations.index');


Route::get('/recommendations/{id}', function ($id) {

    $data = pdacRecommendationsDemoData();

    $rec = collect($data)->firstWhere(
        'id',
        (int) $id
    );

    if (! $rec) {
        abort(404);
    }


    $result = PdacRuleEngine::evaluate(
        $rec['clinical']
    );

    $rec['stage_label'] = pdacStageLabel(
        $rec['clinical'],
        $result['abc_type']
    );


    return view('recommendations.show', [
        'rec' => $rec,
        'result' => $result,
    ]);

})->name('recommendations.show');


/*
|--------------------------------------------------------------------------
| Reports
|--------------------------------------------------------------------------
*/


function pdacReportsDemoData(): array
{
    return [
        [
            'id' => 1,
            'name' => 'Monthly Recommendations Summary',
            'type' => 'recommendations',
            'date_from' => '01/07/2026',
            'date_to' => '31/07/2026',
            'generated_by' => 'Dr. Taieb',
            'created_at' => '01/08/2026 09:15',
            'status' => 'completed',
        ],

        [
            'id' => 2,
            'name' => 'Consultations Overview — August',
            'type' => 'consultations',
            'date_from' => '01/08/2026',
            'date_to' => '21/08/2026',
            'generated_by' => 'Dr. Souabni',
            'created_at' => '21/08/2026 08:40',
            'status' => 'completed',
        ],

        [
            'id' => 3,
            'name' => 'Patients Active Cohort',
            'type' => 'patients',
            'date_from' => '01/01/2026',
            'date_to' => '21/08/2026',
            'generated_by' => 'Dr. Taieb',
            'created_at' => '20/08/2026 17:05',
            'status' => 'pending',
        ],

        [
            'id' => 4,
            'name' => 'Clinical Rules Audit Log',
            'type' => 'audit',
            'date_from' => '01/06/2026',
            'date_to' => '31/07/2026',
            'generated_by' => 'System',
            'created_at' => '01/08/2026 06:00',
            'status' => 'failed',
        ],
    ];
}


Route::get('/reports', function () {

    $stats = [
        'total_patients' => 128,
        'total_recommendations' => 96,
        'total_consultations' => 54,
        'total_conflicts' => 7,
    ];


    $doctors = [
        (object) [
            'id' => 1,
            'name' => 'Dr. Taieb',
        ],

        (object) [
            'id' => 2,
            'name' => 'Dr. Souabni',
        ],

        (object) [
            'id' => 3,
            'name' => 'Dr. Kaci',
        ],
    ];


    $reports = pdacReportsDemoData();


    return view('patients.reports', [
        'stats' => $stats,
        'doctors' => $doctors,
        'reports' => $reports,
    ]);

})->name('reports.index');


/*
|--------------------------------------------------------------------------
| Admin Settings
|--------------------------------------------------------------------------
|
| IMPORTANT:
| These routes use the admin guard because SettingsController
| works with the Admin model.
|
*/


Route::middleware('auth:admin')->group(function () {

    // Settings page
    Route::get('/settings', [SettingsController::class, 'index'])
        ->name('settings');


    // Update admin profile
    Route::put(
        '/settings/profile',
        [SettingsController::class, 'updateProfile']
    )->name('settings.profile.update');


    // Update admin password
    Route::put(
        '/settings/password',
        [SettingsController::class, 'updatePassword']
    )->name('settings.password.update');


    // Deactivate admin account
    Route::post(
        '/settings/deactivate',
        [SettingsController::class, 'deactivate']
    )->name('settings.deactivate');
});
Route::get('/patients/{patient}/details', [PatientController::class, 'details'])
    ->name('patients.details');