@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card header="Admission Letter">
                <div class="text-center py-5">
                    <i class="bi bi-file-earmark-pdf display-1 text-danger"></i>
                    <h3 class="mt-4 fw-bold">Download Your Admission Letter</h3>
                    <p class="text-muted mb-4">Your official admission letter is ready. You can download and print it for your records.</p>
                    
                    <a href="{{ route('student.documents.admission_letter.download') }}" class="btn btn-lg btn-success px-5" target="_blank">
                        <i class="bi bi-download me-2"></i> Download PDF
                    </a>
                </div>
                
                <hr>
                
                <div class="p-4 bg-light rounded">
                    <h5 class="fw-bold">Document Details</h5>
                    <div class="row mt-3">
                        <div class="col-sm-6 text-muted">Student Name:</div>
                        <div class="col-sm-6 fw-bold">{{ auth()->user()->name }}</div>
                        
                        <div class="col-sm-6 text-muted">Student Number:</div>
                        <div class="col-sm-6 fw-bold">{{ $student->student_number }}</div>
                        
                        <div class="col-sm-6 text-muted">Program:</div>
                        <div class="col-sm-6 fw-bold">{{ $student->program }}</div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
