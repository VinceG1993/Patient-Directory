<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all(); // Fetch all appointments
        return view('appointments.index', compact('appointments'));
    }
    
    public function showForm()
    {
        $doctors = User::all();
        $patients = Patient::all();
        return view('appointments.create', compact('doctors', 'patients'));
    }

    public function showByDoctor($id)
    {
        $doctor = User::findOrFail($id);
        $appointments = $doctor->appointments()->with('patient')->get(); // Load patient info

        return view('doctors.appointments', compact('doctor', 'appointments'));
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'deposit_paid' => 'required',
        ]);

        Appointment::create([
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
            'deposit_paid' => filter_var($request->deposit_paid, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment successfully booked!');
    }

    public function store(Request $request)
    {
        Log::info('Received Request:', $request->all()); // Log incoming request

        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date_format:Y-m-d',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'deposit_paid' => 'required',
        ]);

        Log::info('Validated Data:', $validated); // Log after validation

        $appointment = Appointment::create($validated);

        Log::info('Appointment Created:', $appointment->toArray()); // Log database entry

        return redirect()->back()->with('success', 'Appointment booked successfully!');
    }

}

