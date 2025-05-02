@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Patients List</h2>
    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i class="bi bi-plus-lg"></i> Add New Patient</button>
        </div>
        <div class="col-md-6">
            <form method="GET" action="{{ route('patients.index') }}" class="mb-3 d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Search patients..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td><a href="{{ route('records.show', $patient->id) }}">{{ $patient->name }}</a></td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone_number }}</td>
                    <td>{{ $patient->home_address }}</td>
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

                

            @endforeach
        </tbody>
    </table>
</div>

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

                    <button type="submit" class="btn btn-success">Add Patient</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
@endsection