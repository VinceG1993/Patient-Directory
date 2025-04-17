@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row g-4">
        <!-- Patient Directory -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Patients</h5>
                    <p class="card-text">Access patient list and profiles.</p>
                    <a href="{{ route('patients.index') }}" class="btn btn-primary">Go to Patients</a>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Notifications</h5>
                    <p class="card-text">Stay updated on important activity.</p>
                    <a href="#" class="btn btn-primary">View Notifications</a>
                </div>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">Generate and download reports.</p>
                    <a href="#" class="btn btn-primary">Generate Reports</a>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="col-md-6">
            <div class="card shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Manage system preferences.</p>
                    <a href="{{ route('admin.settings') }}" class="btn btn-primary">Go to Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
