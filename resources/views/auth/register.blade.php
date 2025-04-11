@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Register</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="clinic_address" class="form-label">Clinic Address</label>
                <input id="clinic_address" type="text" class="form-control" name="clinic_address" value="{{ old('clinic_address') }}" required>
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>

        <div class="text-center mt-3">
            <small>Already have an account? <a href="{{ route('login') }}">Log in</a></small>
        </div>
    </div>
</div>
@endsection
