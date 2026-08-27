<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ClinicalDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ClinicalRuleController;
use App\Http\Controllers\RcpController;
use App\Http\Controllers\DashboardController;

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
    [PatientController::class, 'clinicalExplanation']
)->name('patients.clinical-explanation');


// Clinical data - generic entry point (patient chosen via dropdown)
Route::get(
    '/clinical-data',
    [ClinicalDataController::class, 'create']
)->name('clinical-data.create');

Route::post(
    '/clinical-data',
    [ClinicalDataController::class, 'storeAny']
)->name('clinical-data.storeAny');


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


Route::get('/clinical-rules', [ClinicalRuleController::class, 'index'])->name('rules.index');
Route::get('/clinical-rules/create', [ClinicalRuleController::class, 'create'])->name('rules.create');
Route::post('/clinical-rules', [ClinicalRuleController::class, 'store'])->name('rules.store');
Route::get('/clinical-rules/{id}', [ClinicalRuleController::class, 'show'])->name('rules.show');
Route::get('/clinical-rules/{id}/edit', [ClinicalRuleController::class, 'edit'])->name('rules.edit');
Route::match(['put', 'post'], '/clinical-rules/{id}', [ClinicalRuleController::class, 'update'])->name('rules.update');
Route::delete('/clinical-rules/{id}', [ClinicalRuleController::class, 'destroy'])->name('rules.destroy');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


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


Route::get('/recommendations', [RecommendationController::class, 'index'])
    ->name('recommendations.index');

Route::get('/recommendations/{id}', [RecommendationController::class, 'show'])
    ->name('recommendations.show');

Route::post('/consultations/{consultation}/recommendations/generate', [RecommendationController::class, 'generate'])
    ->name('recommendations.generate');

Route::post('/recommendations/{id}/validate', [RecommendationController::class, 'validateRecommendation'])
    ->name('recommendations.validate');

Route::post('/recommendations/{id}/reject', [RecommendationController::class, 'reject'])
    ->name('recommendations.reject');

Route::post('/recommendations/{id}/rcp', [RecommendationController::class, 'sendToRcp'])
    ->name('recommendations.rcp');

// RCP meeting sheet (RF-15/16) — the actual meeting record
Route::get('/recommendations/{id}/rcp-sheet/create', [RcpController::class, 'create'])
    ->name('rcp.create');
Route::post('/recommendations/{id}/rcp-sheet', [RcpController::class, 'store'])
    ->name('rcp.store');
Route::get('/recommendations/{id}/rcp-sheet', [RcpController::class, 'show'])
    ->name('rcp.show');



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