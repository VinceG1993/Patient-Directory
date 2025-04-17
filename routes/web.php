<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRecordFieldController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Patients
    Route::resource('patients', PatientController::class);

    // Doctors
    Route::resource('doctors', DoctorController::class);
    Route::get('/doctors/{id}/appointments', [AppointmentController::class, 'showByDoctor'])->name('doctors.appointments');

    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::resource('doctor_availability', DoctorAvailabilityController::class);
    Route::get('/doctor/available-dates', [DoctorAvailabilityController::class, 'getAvailableDates'])->name('doctor.getAvailableDates');
    Route::get('/doctor/available-times', [DoctorAvailabilityController::class, 'getAvailableTimes'])->name('doctor.getAvailableTimes');
    Route::get('/doctor/check-availability', [DoctorAvailabilityController::class, 'checkAvailability'])->name('dac.checkAvailability');
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'showForm'])->name('appointments.create');
    
    // Medical records
    Route::post('/patients/{id}/records/store', [MedicalRecordController::class, 'store'])->name('records.store');
    Route::get('/patients/{id}/records', [MedicalRecordController::class, 'show'])->name('records.show');

    // Settings
    Route::resource('medical_record_fields', MedicalRecordFieldController::class);

});
