<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\MedicalRecordField;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    public function show($id)
    {
        $patient = Patient::findOrFail($id);
        $records = $patient->medicalRecords;

        $allFields = collect();

        foreach ($records as $record) {
            $decodedData = json_decode($record->record_data, true);
            $allFields = $allFields->merge(array_keys($decodedData));
        }

        $uniqueFields = $allFields->unique(); // Remove duplicates

        return view('patients.records', compact('patient', 'records'));
    }

    public function store(Request $request,$id)
    {
        $request->validate([
            'notes' => 'required|string|max:255',
            'record_data' => 'required|array',
            'patient_id' => 'required|exists:patients,id',
        ]);

        MedicalRecord::create([
            'patient_id' => $id, 
            'record_date' => now(),
            'notes' => $request->notes,
            'record_data' => json_encode($request->record_data), 
        ]);

        return redirect()->back()->with('success', 'Record added successfully!');
    }
    
}
