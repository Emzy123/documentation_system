@extends('layouts.app')

@section('content')
<div class="container h-100 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Create Account</h3>
                    <p class="text-muted small">Join to manage your documents</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        <label for="name">Full Name</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required autocomplete="email">
                        <label for="email">Email Address</label>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="new-password">
                        <label for="password">Password</label>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        <label for="password-confirm">Confirm Password</label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold fs-6">
                            Sign Up
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <span class="small text-muted">Already have an account? </span>
                        <a href="{{ route('login') }}" class="text-decoration-none small fw-bold">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
