<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ClinicalDataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctorProfileController;
use App\Http\Controllers\NurseProfileController;
use App\Http\Controllers\VisitorProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ClinicalRuleController;
use App\Http\Controllers\RcpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Services\PdacRuleEngine;


/*
|--------------------------------------------------------------------------
| Public Routes (no authentication required)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.store');

Route::get('/password/forgot', function () {
    return 'TODO: forgot password page';
})->name('password.request');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/register/complete', [RegisterController::class, 'show'])->name('register.complete');
Route::post('/register/complete', [RegisterController::class, 'store'])->name('register.store');


/*
|--------------------------------------------------------------------------
| Protected Routes (must be logged in as admin OR user)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:web,admin')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    /*
    |----------------------------------------------------------------
    | Profile (smart redirect based on role)
    |----------------------------------------------------------------
    */
   Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
Route::get('/admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile');
Route::get('/doctor/profile', [DoctorProfileController::class, 'show'])->name('doctor.profile');
Route::get('/nurse/profile', [NurseProfileController::class, 'show'])->name('nurse.profile');
Route::get('/visitor/profile', [VisitorProfileController::class, 'show'])->name('visitor.profile');
    /*
    |----------------------------------------------------------------
    | Patients
    |----------------------------------------------------------------
    */
    Route::resource('patients', PatientController::class);

    Route::get(
        '/patients/{id}/clinical-explanation',
        [PatientController::class, 'clinicalExplanation']
    )->name('patients.clinical-explanation');

    Route::get(
        '/clinical-data',
        [ClinicalDataController::class, 'create']
    )->name('clinical-data.create');

    Route::post(
        '/clinical-data',
        [ClinicalDataController::class, 'storeAny']
    )->name('clinical-data.storeAny');

    Route::get(
        '/patients/{id}/clinical-data',
        [ClinicalDataController::class, 'edit']
    )->name('clinical-data.edit');

    Route::match(
        ['put', 'post'],
        '/patients/{id}/clinical-data',
        [ClinicalDataController::class, 'store']
    )->name('clinical-data.store');

    Route::get('/patients/{patient}/details', [PatientController::class, 'details'])
        ->name('patients.details');


    /*
    |----------------------------------------------------------------
    | Clinical Rules
    |----------------------------------------------------------------
    */
    Route::get('/clinical-rules', [ClinicalRuleController::class, 'index'])->name('rules.index');
    Route::get('/clinical-rules/create', [ClinicalRuleController::class, 'create'])->name('rules.create');
    Route::post('/clinical-rules', [ClinicalRuleController::class, 'store'])->name('rules.store');
    Route::get('/clinical-rules/{id}', [ClinicalRuleController::class, 'show'])->name('rules.show');
    Route::get('/clinical-rules/{id}/edit', [ClinicalRuleController::class, 'edit'])->name('rules.edit');
    Route::match(['put', 'post'], '/clinical-rules/{id}', [ClinicalRuleController::class, 'update'])->name('rules.update');
    Route::delete('/clinical-rules/{id}', [ClinicalRuleController::class, 'destroy'])->name('rules.destroy');


    /*
    |----------------------------------------------------------------
    | Dashboard
    |----------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |----------------------------------------------------------------
    | Help
    |----------------------------------------------------------------
    */
    Route::get('/help', function () {
        return view('pages.help');
    })->name('help');


    /*
    |----------------------------------------------------------------
    | Recommendations
    |----------------------------------------------------------------
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

    Route::get('/recommendations/{id}/rcp-sheet/create', [RcpController::class, 'create'])
        ->name('rcp.create');
    Route::post('/recommendations/{id}/rcp-sheet', [RcpController::class, 'store'])
        ->name('rcp.store');
    Route::get('/recommendations/{id}/rcp-sheet', [RcpController::class, 'show'])
        ->name('rcp.show');


    /*
    |----------------------------------------------------------------
    | Reports
    |----------------------------------------------------------------
    */
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports/{reportId}/download', [ReportController::class, 'download'])->name('reports.download');


    /*
    |----------------------------------------------------------------
    | Admin-only routes (settings + user management)
    |----------------------------------------------------------------
    */
    Route::middleware('auth:admin')->group(function () {

        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings');

        Route::put(
            '/settings/profile',
            [SettingsController::class, 'updateProfile']
        )->name('settings.profile.update');

        Route::put(
            '/settings/password',
            [SettingsController::class, 'updatePassword']
        )->name('settings.password.update');

        Route::post(
            '/settings/deactivate',
            [SettingsController::class, 'deactivate']
        )->name('settings.deactivate');

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
    });

});