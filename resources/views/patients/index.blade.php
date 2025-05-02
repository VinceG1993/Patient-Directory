@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Patients List</h2>
        <div class="row">
            <div class="col-md-6">
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addPatientModal"><i
                        class="bi bi-plus-lg"></i> Add New Patient</button>
            </div>
            <div class="col-md-6">
                <form method="GET" action="{{ route('patients.index') }}" class="mb-3 d-flex">
                    <input type="search" name="search" class="form-control me-2" placeholder="Search patients..."
                        value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div id="patientsTable">
            @include('patients._table', ['patients' => $patients])
        </div>               
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

                        <!-- First Name -->
                        <div class="mb-3">
                            <label>First Name</label>
                            <input type="text" name="fname" class="form-control @error('fname') is-invalid @enderror" value="{{ old('fname') }}" required>
                            @error('fname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Middle Name -->
                        <div class="mb-3">
                            <label>Middle Name</label>
                            <input type="text" name="mname" class="form-control @error('mname') is-invalid @enderror" value="{{ old('mname') }}">
                            @error('mname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="mb-3">
                            <label>Last Name</label>
                            <input type="text" name="lname" class="form-control @error('lname') is-invalid @enderror" value="{{ old('lname') }}" required>
                            @error('lname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="text" name="home_address"
                                class="form-control @error('home_address') is-invalid @enderror" value="{{ old('home_address') }}" required>
                            @error('home_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Add Patient</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var addPatientModal = new bootstrap.Modal(document.getElementById('addPatientModal'));
                addPatientModal.show();
            });
        </script>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('input[name="search"]').on('input', function () {
                let searchQuery = $(this).val();

                $.ajax({
                    url: "{{ route('patients.index') }}",
                    type: "GET",
                    data: { search: searchQuery },
                    success: function (data) {
                        $('#patientsTable').html(data);
                    }
                });
            });

            // Handle pagination links
            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');

                $.get(url, function (data) {
                    $('#patientsTable').html(data);
                });
            });
        });
    </script>
@endsection