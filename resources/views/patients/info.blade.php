@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">{{ $patient->fname }} {{ $patient->mname }} {{ $patient->lname }}
        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </h2>
    
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Information</h2>
                    <div class="form-check form-switch mb-1">
                        <input class="form-check-input" type="checkbox" role="switch" id="toggleForm">
                        <label class="form-check-label" for="toggleForm">Edit</label>
                    </div>
                </div>
                <div class="card-body">
                    <form id="info" action="{{ route('patients.update', $patient->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- First Name -->
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ $patient->fname }}" required disabled>
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="mb-3">
                            <label>Middle Name</label>
                            <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ $patient->mname }}" placeholder="-" disabled>
                            @error('mname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ $patient->lname }}" required disabled>
                            @error('lname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $patient->email }}" required disabled>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror" value="{{ $patient->phone_number }}" required disabled>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="home_address"
                                class="form-control @error('home_address') is-invalid @enderror" value="{{ $patient->home_address }}" required disabled>
                            @error('home_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button id="saveInfo" type="submit" class="btn btn-success d-none">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h2>Records</h2>
                </div>
                <div class="card-body">
                    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                        <i class="bi bi-plus-lg"></i> Add New Record
                    </button>
                
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date</th>
                                <th>Notes</th>
                                @foreach ($uniqueFields as $fieldName)
                                    <th>{{ $fieldName }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $index => $record)
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ $record->record_date }}</td>
                                    <td>{{ $record->notes }}</td>
                    
                                    @foreach ($uniqueFields as $fieldName)
                                        <td>{{ $allData[$index][$fieldName] ?? '-' }}</td> 
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Add Record Modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="recordAdd" action="{{ route('records.store', ['id' => $patient->id]) }}" method="POST">
                    @csrf

                    <!-- Hidden input to pass patient_id -->
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    <div class="mb-3">
                        <label>Notes</label>
                        <input type="text" name="notes" class="form-control" required>
                    </div>

                    @foreach ($fields as $field)
                        @if ($field->is_required)
                            <div class="mb-3">
                                <label>{{ $field->field_name }}</label>
                                <!-- Hidden input to pass field_name -->
                                <input type="hidden" name="record_data[]" value="{{ $field->field_name }}">
                                <input type="{{ $field->field_type }}" name="record_data[]" class="form-control" required>
                            </div>
                        @endif
                    @endforeach

                    <div id="fieldsContainer" class="mt-3">
                        <!-- Dynamic fields will be added here -->
                    </div>

                    <div class="mb-3">
                        <label>Record Data</label>
                        <select id="selectField" class="form-select" name="selectField">
                            <option value="">Choose...</option>
                            @foreach ($fields as $field)
                                @if(!$field->is_required)
                                    <option value="{{ $field->id }}">{{ $field->field_name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addField()">Add Field</button>
                    </div>
                    <button type="submit" class="btn btn-success">Add Record</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>

    let fields = @json($fields);
    let addedFields = new Set(); // Track added field IDs

    function addField() {
        let select = document.getElementById("selectField");
        let fieldID = select.value;

        if (!fieldID) return; // Do nothing if no field is selected
        if (addedFields.has(fieldID)) {
            alert("This field has already been added.");
            return;
        }

        let field = fields.find(i => i.id === Number(fieldID));
        let container = document.getElementById("fieldsContainer");

        let fieldWrapper = document.createElement("div");
        fieldWrapper.className = "mb-3 field-wrapper";
        fieldWrapper.setAttribute("data-id", fieldID);

        let label = document.createElement("label");
        label.innerText = field.field_name;

        let hidden = document.createElement("input");
        hidden.type = "hidden";
        hidden.name = "record_data[]";
        hidden.value = field.field_name;

        let input;

        if (field.field_type === "boolean") {
            input = document.createElement("select");
            input.name = "record_data[]";
            input.className = "form-select mt-2";

            let optionYes = document.createElement("option");
            optionYes.value = "Yes";
            optionYes.text = "Yes";

            let optionNo = document.createElement("option");
            optionNo.value = "No";
            optionNo.text = "No";

            input.appendChild(optionYes);
            input.appendChild(optionNo);
        } else {
            input = document.createElement("input");
            input.type = field.field_type;
            input.name = "record_data[]";
            input.className = "form-control mt-2";
            input.placeholder = field.default_value;
        }

        let removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "btn btn-danger btn-sm mt-2";
        removeBtn.innerText = "Remove";
        removeBtn.onclick = function () {
            removeField(fieldID);
        };

        fieldWrapper.appendChild(label);
        fieldWrapper.appendChild(hidden);
        fieldWrapper.appendChild(input);
        fieldWrapper.appendChild(removeBtn);
        
        container.appendChild(fieldWrapper);
        addedFields.add(fieldID);
    }

    function removeField(fieldID) {
        let container = document.getElementById("fieldsContainer");
        let fieldWrapper = document.querySelector(`.field-wrapper[data-id='${fieldID}']`);
        if (fieldWrapper) {
            container.removeChild(fieldWrapper);
            addedFields.delete(fieldID); // Remove from set
        }
    }

    // Reset modal on close
    document.getElementById("addRecordModal").addEventListener("hidden.bs.modal", function () {
        document.getElementById("fieldsContainer").innerHTML = ""; // Clear added fields
        addedFields.clear(); // Clear tracking set
    });

    const toggle = document.getElementById('toggleForm');
    const form = document.getElementById('info');
    const button =document.getElementById('saveInfo');

    toggle.addEventListener('change', () => {
        const isEnabled = toggle.checked;
        Array.from(form.elements).forEach(el => el.disabled = !isEnabled);
        button.classList.toggle('d-none', !toggle.checked);
    });

</script>
@endsection