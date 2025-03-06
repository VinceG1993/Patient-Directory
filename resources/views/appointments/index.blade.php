@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Appointments List</h2>
    <a href="{{ route('appointments.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> New Appointment
    </a>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Appointments Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->doctor->name }}</td> 
                        <td>{{ $appointment->patient->name }}</td> 
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                        <td>
                            <span class="badge 
                                {{ $appointment->status == 'Pending' ? 'bg-warning' : 
                                   ($appointment->status == 'Confirmed' ? 'bg-success' : 'bg-danger') }}">
                                {{ $appointment->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
