<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorAvailabilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [HomeController::class, 'index'])->name('home');

//Patients
Route::resource('patients', PatientController::class);

//Doctors
Route::resource('doctors', DoctorController::class);
Route::get('/doctors/{id}/appointments', [AppointmentController::class, 'showByDoctor'])->name('doctors.appointments');

//Appointments
Route::resource('appointments', AppointmentController::class);
Route::resource('doctor_availability', DoctorAvailabilityController::class);
Route::get('/doctor/available-dates', [DoctorAvailabilityController::class, 'getAvailableDates'])->name('doctor.getAvailableDates');
Route::get('/doctor/available-times', [DoctorAvailabilityController::class, 'getAvailableTimes'])->name('doctor.getAvailableTimes');
Route::get('/doctor/check-availability', [DoctorAvailabilityController::class, 'checkAvailability'])->name('dac.checkAvailability');
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('/appointments/create', [AppointmentController::class, 'showForm'])->name('appointments.create');
Route::post('/appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');

//Records
Route::resource('records', MedicalRecordController::class);
Route::post('/patients/{id}/records/store', [MedicalRecordController::class, 'store'])->name('records.store');
Route::get('/patients/{id}/records', [MedicalRecordController::class, 'show'])->name('records.show');

//Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');