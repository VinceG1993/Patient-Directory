@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Settings – Medical Record Fields</h2>

    {{-- Add New Field Form --}}
    <div class="card mb-4">
        <div class="card-header">Add New Field</div>
        <div class="card-body">
            <form action="{{ route('medical_record_fields.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="field_name" class="form-label">Field Name</label>
                    <input type="text" name="field_name" id="field_name" class="form-control" required>
                </div>
            
                <div class="mb-3">
                    <label for="field_type" class="form-label">Field Type</label>
                    <select name="field_type" id="field_type" class="form-select" required>
                        <option value="">Select type</option>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="date">Date</option>
                        <option value="boolean">Boolean</option>
                    </select>
                </div>
            
                <div class="mb-3">
                    <label for="default_value" class="form-label">Default Value</label>
                    <input type="text" name="default_value" id="default_value" class="form-control">
                </div>
            
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_required" id="is_required">
                    <label class="form-check-label" for="is_required">Required</label>
                </div>
            
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active">
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            
                <button type="submit" class="btn btn-success">Add Field</button>
            </form>            
        </div>
    </div>

    {{-- Existing Fields --}}
    <div class="card">
        <div class="card-header">Existing Fields</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Type</th>
                        <th>Required</th>
                        <th>Active</th>
                        <th>Default</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fields as $field)
                    <tr>
                        <td>{{ $field->field_name }}</td>
                        <td>{{ $field->field_type }}</td>
                        <td>{{ $field->is_required ? 'Yes' : 'No' }}</td>
                        <td>{{ $field->is_active ? 'Yes' : 'No' }}</td>
                        <td>{{ $field->default_value }}</td>
                        <td>
                            <form action="{{ route('medical_record_fields.destroy', $field->id) }}" method="POST" onsubmit="return confirm('Delete this field?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if ($fields->isEmpty())
                    <tr><td colspan="6" class="text-center">No fields added yet.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
