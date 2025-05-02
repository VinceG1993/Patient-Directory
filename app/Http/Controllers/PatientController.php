<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $doctorId = auth()->user()->id;

        $query = Patient::where('doctor_id', $doctorId);

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'like', "%{$search}%")
                ->orWhere('mname', 'like', "%{$search}%")
                ->orWhere('lname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('patients._table', compact('patients'))->render();
        }

        return view('patients.index', compact('patients'));
    }

    

    /**
     * Show the form for creating a new patient.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|max:42',
            'mname' => 'nullable|string|max:42',
            'lname' => 'required|string|max:42',
            'email' => 'required|email|max:42|unique:patients,email',
            'phone_number' => 'required|string|max:15',
            'home_address' => 'required|string|max:255',
        ]);

        Patient::create([
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'home_address' => $request->home_address,
            'doctor_id' => auth()->id(), 
        ]);

        return redirect()->back()->with('success', 'New patient added successfully!');
    }

    

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'fname' => 'required|string|max:42',
            'mname' => 'nullable|string|max:42',
            'lname' => 'required|string|max:42',
            'email' => 'required|email|max:42|unique:patients,email,' . $patient->id,
            'phone_number' => 'required|string|max:15',
            'home_address' => 'required|string|max:255',
        ]);
    
        $patient->update($request->all());
    
        return redirect()->back()->with('success', 'Patient updated successfully!');
    }    

    /**
     * Remove the specified patient from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
    }
}
