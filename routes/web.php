<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'fr', 'en'])) {
        session(['locale' => $locale]);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments-search', [AppointmentController::class, 'search'])->name('appointments.search');
    Route::resource('services', \App\Http\Controllers\ServiceController::class);
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::get('/patients-search', [\App\Http\Controllers\PatientController::class, 'search'])->name('patients.search');
    
    // Patient Booking Routes
    Route::get('/book-appointment', [\App\Http\Controllers\PatientAppointmentController::class, 'create'])->name('patient.book');
    Route::post('/book-appointment', [\App\Http\Controllers\PatientAppointmentController::class, 'store'])->name('patient.book.store');

    Route::post('/dashboard/complete-diagnosis/{appointment}', [DashboardController::class, 'completeDiagnosis'])->name('dashboard.complete-diagnosis');
    Route::get('/medical-reports/{report}/download', [DashboardController::class, 'downloadReport'])->name('medical-reports.download');
});

require __DIR__.'/auth.php';
