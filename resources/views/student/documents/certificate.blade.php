@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card header="Certificate of Completion">
                <div class="text-center py-5">
                    <i class="bi bi-award display-1 text-warning"></i>
                    <h3 class="mt-4 fw-bold">Download Certificate</h3>
                    <p class="text-muted mb-4">Congratulations! Your certificate is ready for download.</p>
                    
                    <a href="{{ route('student.documents.certificate.download') }}" class="btn btn-lg btn-success px-5" target="_blank">
                        <i class="bi bi-download me-2"></i> Download PDF
                    </a>
                </div>
                
                <hr>
                
                <div class="p-4 bg-light rounded">
                    <h5 class="fw-bold">Certificate Details</h5>
                    <div class="row mt-3">
                        <div class="col-sm-6 text-muted">Recipient:</div>
                        <div class="col-sm-6 fw-bold">{{ auth()->user()->name }}</div>
                        
                        <div class="col-sm-6 text-muted">Program:</div>
                        <div class="col-sm-6 fw-bold">{{ $student->program }}</div>
                        
                        <div class="col-sm-6 text-muted">Issued Date:</div>
                        <div class="col-sm-6 fw-bold">{{ now()->format('M d, Y') }}</div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
