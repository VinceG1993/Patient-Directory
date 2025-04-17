<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecordField;
use Illuminate\Http\Request;

class MedicalRecordFieldController extends Controller
{
    public function index()
    {
        // Get the ID of the logged-in doctor (user)
        $doctorId = auth()->user()->id;

        // Fetch only the patients assigned to this doctor
        $fields = MedicalRecordField::where('doctor_id', $doctorId)->latest()->paginate(10);
        return view('admin.settings', compact('fields'));
    }

    public function create()
    {
        return view('medical_record_fields.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,date,boolean',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
            'default_value' => 'nullable|string|max:255',
        ]);

        MedicalRecordField::create([
            'field_name' => $request->field_name,
            'field_type' => $request->field_type,
            'is_active' => $request->has('is_active'), // true/false
            'is_required' => $request->has('is_required'), // true/false
            'default_value' => $request->default_value,
            'doctor_id' => auth()->id(), 
        ]);

        return redirect()->route('medical_record_fields.index')->with('success', 'Field created successfully.');
    }

    public function show(MedicalRecordField $medicalRecordField)
    {
        return view('medical_record_fields.show', compact('medicalRecordField'));
    }

    public function edit(MedicalRecordField $medicalRecordField)
    {
        return view('medical_record_fields.edit', compact('medicalRecordField'));
    }

    public function update(Request $request, MedicalRecordField $medicalRecordField)
    {
        $request->validate([
            'field_name' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,date,boolean',
            'is_active' => 'boolean',
            'is_required' => 'boolean',
            'default_value' => 'nullable|string|max:255',
        ]);

        $medicalRecordField->update($request->all());

        return redirect()->route('medical_record_fields.index')->with('success', 'Field updated successfully.');
    }

    public function destroy(MedicalRecordField $medicalRecordField)
    {
        $medicalRecordField->delete();

        return redirect()->route('medical_record_fields.index')->with('success', 'Field deleted successfully.');
    }
}
