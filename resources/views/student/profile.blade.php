@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card header="My Profile">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <hr>
                    <h5 class="fw-bold mb-3">Academic Info</h5>
                    <div class="mb-3">
                        <label class="form-label text-muted">Student Number</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->student->student_number ?? 'N/A' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Program</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->student->program ?? 'N/A' }}" readonly>
                    </div>

                    <hr>
                    <h5 class="fw-bold mb-3">Change Password</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection
