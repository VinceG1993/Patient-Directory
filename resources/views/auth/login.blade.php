@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">Login</h3>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" required autofocus>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" type="password" class="form-control" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                        <i id="eyeIcon" class="bi bi-eye-slash"></i> 
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            

            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="text-center mt-3">
            <small>Don’t have an account? <a href="{{ route('register') }}">Sign up</a></small>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // Toggle between eye-slash and eye icons
            if (type === 'password') {
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });
    </script>
@endsection