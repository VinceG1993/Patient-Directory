@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">{{ $patient->name }}'s Medical Records</h2>
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

</script>
@endsection