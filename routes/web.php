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

    Route::post('/diagnose/store', [DashboardController::class, 'storeDiagnosis'])->name('diagnose.store');
    Route::get('/medical-reports/{report}/download', [DashboardController::class, 'downloadReport'])->name('medical-reports.download');
    
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::patch('/settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::patch('/settings/clinic', [\App\Http\Controllers\SettingsController::class, 'updateClinic'])->name('settings.clinic.update');

    Route::get('/notifications/{id}/mark-as-read', [DashboardController::class, 'markNotificationAsRead'])->name('notifications.mark-as-read');
});

require __DIR__.'/auth.php';
