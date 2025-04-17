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
        $fields = MedicalRecordField::where('doctor_id', auth()->id())->get();

        $allNames = collect();
        $allData = [];

        foreach ($records as $record) {
            $decodedData = json_decode($record->record_data, true);

            if (is_array($decodedData)) {
                $row = [];
                for ($i = 0; $i < count($decodedData); $i += 2) {
                    $fieldName = $decodedData[$i];
                    $fieldValue = $decodedData[$i + 1] ?? '';

                    $row[$fieldName] = $fieldValue; 
                    $allNames->push($fieldName);
                }
                $allData[] = $row;
            }
        }

        $uniqueFields = $allNames->unique();

        return view('patients.records', compact('patient', 'records', 'fields', 'allData', 'uniqueFields'));
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
