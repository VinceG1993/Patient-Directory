<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DoctorAvailability;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use Carbon\Carbon;

class DoctorAvailabilityController extends Controller
{
    /**
     * Display a listing of the doctor availability.
     */
    public function index()
    {
        $availabilities = DoctorAvailability::with('doctor')->get();
        return view('doctor_availability.index', compact('availabilities'));
    }

    /**
     * Show the form for creating a new availability.
     */
    public function create()
    {
        $doctors = Doctor::all(); // Fetch all doctors
        return view('doctor_availability.create', compact('doctors'));
    }

    /**
     * Store a newly created availability in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        DoctorAvailability::create($request->all());

        return redirect()->route('doctor_availability.index')->with('success', 'Availability added successfully.');
    }

    /**
     * Show the form for editing the specified availability.
     */
    public function edit($id)
    {
        $availability = DoctorAvailability::findOrFail($id);
        $doctors = Doctor::all();
        return view('doctor_availability.edit', compact('availability', 'doctors'));
    }

    /**
     * Update the specified availability in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $availability = DoctorAvailability::findOrFail($id);
        $availability->update($request->all());

        return redirect()->route('doctor_availability.index')->with('success', 'Availability updated successfully.');
    }

    /**
     * Remove the specified availability from storage.
     */
    public function destroy($id)
    {
        $availability = DoctorAvailability::findOrFail($id);
        $availability->delete();

        return redirect()->route('doctor_availability.index')->with('success', 'Availability deleted successfully.');
    }

    public function checkAvailability(Request $request)
    {
        Log::info('Checking availability for:', [
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
        ]);
        // Get the day of the week from the selected appointment date
        $dayOfWeek = date('l', strtotime($request->appointment_date)); // Returns 'Monday', 'Tuesday', etc.

        // Check if the doctor is available on this day and time
        $exists = DoctorAvailability::where('doctor_id', $request->doctor_id)
            ->where('day_of_week', $dayOfWeek)
            ->whereTime('start_time', '<=', $request->appointment_time)
            ->whereTime('end_time', '>=', $request->appointment_time)
            ->exists();

        Log::info('Appointment exists?', ['exists' => $exists]);

        return response()->json(['available' => !$exists]);
    }

    public function getAvailableDates(Request $request)
    {
        $doctorId = $request->doctor_id;

        if (!$doctorId) {
            return response()->json(['error' => 'Doctor ID is required'], 400);
        }

        // Get available days for the doctor (e.g., ['Monday', 'Wednesday'])
        $availableDays = DoctorAvailability::where('doctor_id', $doctorId)
            ->pluck('day_of_week')
            ->toArray();

        return response()->json(['availableDays' => $availableDays]);
    }

    public function getAvailableTimes(Request $request)
    {
        $doctorId = $request->doctor_id;
        $selectedDate = Carbon::parse($request->appointment_date);
        $dayOfWeek = $selectedDate->format('l'); // e.g., 'Monday'

        // Fetch available times for this doctor on the selected day
        $availabilities = DoctorAvailability::where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->get();

        $timeSlots = [];

        foreach ($availabilities as $availability) {
            $startTime = Carbon::parse($availability->start_time);
            $endTime = Carbon::parse($availability->end_time);

            while ($startTime < $endTime) {
                $timeSlots[] = $startTime->format('H:i'); // Store time in 'HH:MM' format
                $startTime->addMinutes(30); // Adjust interval as needed
            }
        }

        return response()->json(['availableTimes' => $timeSlots]);
    }
}
