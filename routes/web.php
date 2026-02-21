<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\EvaluationController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Evaluation Routes (accessible via QR)
|--------------------------------------------------------------------------
*/
Route::get('/evaluations/{event}/form', [EvaluationController::class, 'form'])->name('evaluations.form');
Route::post('/evaluations/{event}', [EvaluationController::class, 'store'])->name('evaluations.store');

Route::get('/evaluations/thankyou', [EvaluationController::class, 'thankyou'])->name('evaluations.thankyou'); 
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Organizations management
    Route::get('/organizations', [AdminController::class, 'indexOrganizations'])->name('admin.organizations.index');
    Route::post('/organizations', [AdminController::class, 'storeOrganization'])->name('admin.organizations.store');
    Route::put('/organizations/{organization}/password', [AdminController::class, 'updatePassword'])->name('admin.organizations.update');
    Route::delete('/organizations/{organization}', [AdminController::class, 'destroyOrganization'])->name('admin.organizations.destroy');

    // Admin profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
});

/*
|--------------------------------------------------------------------------
| Organization Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('organization')->group(function () {
    Route::get('/dashboard', [OrganizationController::class, 'dashboard'])->name('organization.dashboard');
    /* Profile Management */
    Route::get('/profile', [OrganizationController::class, 'profile'])->name('profile.index');
    Route::put('/profile', [OrganizationController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [OrganizationController::class, 'updatePassword'])->name('profile.password');

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    */
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Quick actions
    Route::patch('/events/{event}/approve', [EventController::class, 'approve'])->name('events.approve');
    Route::patch('/events/{event}/finish', [EventController::class, 'finish'])->name('events.finish');

    /*
    |--------------------------------------------------------------------------
    | Students
    |--------------------------------------------------------------------------
    */
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student_id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{student_id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/bulk-upload', [StudentController::class, 'bulkStore'])->name('students.bulk.store');

    /*
    |--------------------------------------------------------------------------
    | Collections
    |--------------------------------------------------------------------------
    */
    Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
    Route::get('/collections/{event}', [CollectionController::class, 'show'])->name('collections.show');
    Route::post('/collections/{event}/{student_id}/pay', [CollectionController::class, 'pay'])->name('collections.pay');

    /*
    |--------------------------------------------------------------------------
    | Evaluations
    |--------------------------------------------------------------------------
    |
    | These routes are for organizations (authenticated users).
    | They can view finished events, see results, and generate QR codes.
    |
    */
    Route::get('/evaluations', [EvaluationController::class, 'index'])
    ->name('evaluations.index');

    Route::get('/evaluations/{event}/results', [EvaluationController::class, 'results'])
        ->name('evaluations.results');

    Route::get('/evaluations/{event}/qr', [EvaluationController::class, 'qr'])
        ->name('evaluations.qr');

});
