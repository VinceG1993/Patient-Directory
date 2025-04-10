@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Patients List</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="bi bi-plus-lg"></i> Add New Patient</button>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone_number }}</td>
                    <td>{{ $patient->home_address }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPatientModal{{ $patient->id }}">Edit</button>
                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('records.show', $patient->id) }}" class="btn btn-sm btn-primary">View Records</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editPatientModal{{ $patient->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Patient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $patient->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $patient->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone_number" class="form-control" value="{{ $patient->phone_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" name="home_address" class="form-control" value="{{ $patient->home_address }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                <!-- Add Patient Modal -->
                <div class="modal fade" id="addPatientModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Patient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="patientAdd" action="{{ route('patients.store') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone_number" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Address</label>
                                        <input type="text" name="home_address" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password (Min. 6 characters)</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Password must be at least 6 characters long.
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">Add Patient</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
     document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password");
        const form = document.getElementById("addPatientModal"); 
        const submitButton = form.querySelector("button[type='submit']");

        form.addEventListener("input", function () {
            let allFilled = [...form.querySelectorAll("input, textarea")].every(input => input.value.trim() !== "");
            
            if (allFilled){
                if (passwordInput.value.length < 6) {
                    passwordInput.classList.add("is-invalid");
                    submitButton.disabled = true; 
                } else {
                    passwordInput.classList.remove("is-invalid");
                    submitButton.disabled = false; 
                }
            } else{
                submitButton.disabled = false;
            }
        });

        // Prevent form submission if the password is still invalid
        form.addEventListener("submit", function (event) {
            if (passwordInput.value.length < 6) {
                passwordInput.classList.add("is-invalid");
                event.preventDefault(); // Stop form submission
            }
        });
    });   
</script>
@endsection