@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Settings – Medical Record Fields</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                
                    {{-- Text Input --}}
                    <input type="text" name="default_value" id="default_value_text" class="form-control" disabled placeholder="Select Field Type">
                
                    {{-- Number Input --}}
                    <input type="number" name="default_value" id="default_value_number" class="form-control d-none" disabled placeholder="Select Field Type">
                
                    {{-- Date Input --}}
                    <input type="date" name="default_value" id="default_value_date" class="form-control d-none" disabled placeholder="Select Field Type">
                
                    {{-- Boolean Select --}}
                    <select name="default_value" id="default_value_boolean" class="form-select d-none" disabled>
                        <option value="" disabled selected>Select True/False</option>
                        <option value="1">True</option>
                        <option value="0">False</option>
                    </select>
                </div>    
            
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_required" id="is_required" value="0">
                    <label class="form-check-label" for="is_required">Required</label>
                </div>
            
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active" >Active</label>
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
                        <td>
                            @if ($field->field_type === 'boolean')
                                {{ $field->default_value === '1' ? 'True' : 'False' }}
                            @else
                                {{ $field->default_value }}
                            @endif
                        </td>
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fieldType = document.getElementById('field_type');
        
            const inputText = document.getElementById('default_value_text');
            const inputNumber = document.getElementById('default_value_number');
            const inputDate = document.getElementById('default_value_date');
            const inputBoolean = document.getElementById('default_value_boolean');
        
            function updateDefaultInput() {
                // Hide and disable all inputs, and clear any previous values
                [inputText, inputNumber, inputDate, inputBoolean].forEach(input => {
                    input.classList.add('d-none');
                    input.disabled = true;
                    input.value = '';  // Clear any previous value
                    // Set placeholder to default when the field is disabled
                    if (input.tagName === 'INPUT') {
                        input.setAttribute('placeholder', 'Select Field Type');
                    }
                });
        
                // If no field type is selected, display the blank disabled input
                if (fieldType.value === '') {
                    inputText.classList.remove('d-none');
                    inputText.disabled = true;
                    inputText.setAttribute('placeholder', 'Select Field Type');
                    return;
                }
        
                // Show and enable the appropriate input based on field type
                switch (fieldType.value) {
                    case 'text':
                        inputText.classList.remove('d-none');
                        inputText.disabled = false;
                        inputText.removeAttribute('placeholder');
                        break;
                    case 'number':
                        inputNumber.classList.remove('d-none');
                        inputNumber.disabled = false;
                        inputNumber.removeAttribute('placeholder');
                        break;
                    case 'date':
                        inputDate.classList.remove('d-none');
                        inputDate.disabled = false;
                        inputDate.removeAttribute('placeholder');
                        break;
                    case 'boolean':
                        inputBoolean.classList.remove('d-none');
                        inputBoolean.disabled = false;
                        break;
                }
            }
        
            updateDefaultInput();
            fieldType.addEventListener('change', updateDefaultInput);
        });
    </script>    
@endsection