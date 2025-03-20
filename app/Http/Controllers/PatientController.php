<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecordField;

class PatientController extends Controller
{
    /**
     * Display a listing of the patients.
     */
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
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
            'name' => 'required|string|max:42',
            'email' => 'required|email|max:42|unique:patients,email',
            'phone_number' => 'required|string|max:15',
            'home_address' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
    
        Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'home_address' => $request->home_address,
            'password' => bcrypt($request->password),
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
            'name' => 'required|string|max:42',
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

    public function showRecords($id)
    {
        $patient = Patient::findOrFail($id);
        $records = $patient->medicalRecords;
        $fields = MedicalRecordField::all();

        $allNames = collect();
        $allData = [];

        foreach ($records as $record) {
            $decodedData = json_decode($record->record_data, true);

            if (is_array($decodedData)) {
                $row = [];
                for ($i = 0; $i < count($decodedData); $i += 2) {
                    $fieldName = $decodedData[$i]; // Even index = Field Name
                    $fieldValue = $decodedData[$i + 1] ?? ''; // Odd index = Value

                    $row[$fieldName] = $fieldValue; 
                    $allNames->push($fieldName);
                }
                $allData[] = $row;
            }
        }

        $uniqueFields = $allNames->unique();

        return view('patients.records', compact('patient', 'records', 'fields', 'allData', 'uniqueFields'));
    }

}
