@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-8 text-center">
            <div class="display-1 fw-bold text-muted mb-4">404</div>
            <h1 class="h2 mb-4">Page Not Found</h1>
            <p class="lead text-muted mb-5">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="bi bi-house-door me-2"></i> Return Home
            </a>
        </div>
    </div>
</div>
@endsection
