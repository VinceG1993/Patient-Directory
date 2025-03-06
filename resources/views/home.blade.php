@extends('layouts.app')

@section('title', 'Home - EMR')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Welcome to the EMR System</h1>
        <p class="text-center">This is the homepage for the EMR system.</p>

        <div class="text-center">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Book an Appointment</a>
        </div>
    </div>
@endsection
