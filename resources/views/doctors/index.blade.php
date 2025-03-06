@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Doctors List</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addDoctorModal"><i class="bi bi-plus-lg"></i> Add New Doctor</button>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Clinic Address</th>
                <th>Deposit Required</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->id }}</td>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone_number }}</td>
                    <td>{{ $doctor->clinic_address }}</td>
                    <td>{{ $doctor->deposit_required ? 'Yes' : 'No' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDoctorModal{{ $doctor->id }}">Edit</button>
                        <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('doctors.appointments', $doctor->id) }}" class="btn btn-sm btn-primary">View Appointments</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editDoctorModal{{ $doctor->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Doctor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $doctor->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ $doctor->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone_number" class="form-control" value="{{ $doctor->phone_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Clinic Address</label>
                                        <input type="text" name="clinic_address" class="form-control" value="{{ $doctor->clinic_address }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Deposit Required</label>
                                        <select name="deposit_required" class="form-select">
                                            <option value="1" {{ $doctor->deposit_required ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ !$doctor->deposit_required ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->

                <!-- Add Doctor Modal -->
                <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Doctor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="doctorAdd" action="{{ route('doctors.store') }}" method="POST">
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
                                        <label>Clinic Address</label>
                                        <input type="text" name="clinic_address" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Deposit Required</label>
                                        <select name="deposit_required" class="form-select">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label>Password (Min. 6 characters)</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                        <div class="invalid-feedback">
                                            Password must be at least 6 characters long.
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success" disabled>Add Doctor</button>
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
        const form = document.getElementById("addDoctorModal");
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