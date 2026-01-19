@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center py-5">
        <div class="col-md-8 text-center">
            <div class="display-1 fw-bold text-danger mb-4">500</div>
            <h1 class="h2 mb-4">Server Error</h1>
            <p class="lead text-muted mb-5">
                Something went wrong on our servers. We are working to fix the issue. Please try again later.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                <i class="bi bi-house-door me-2"></i> Return Home
            </a>
        </div>
    </div>
</div>
@endsection
