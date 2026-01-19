@extends('layouts.app')

@section('content')
<div class="container h-100 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Welcome Back</h3>
                    <p class="text-muted small">Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <label for="email">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">
                                Remember Me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold fs-6">
                            Sign In
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <span class="small text-muted">Don't have an account? </span>
                        <a href="{{ route('register') }}" class="text-decoration-none small fw-bold">Create Account</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
