@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card header="Student ID Card">
                <div class="text-center py-5">
                    <i class="bi bi-person-badge display-1 text-info"></i>
                    <h3 class="mt-4 fw-bold">Download Your ID Card</h3>
                    <p class="text-muted mb-4">Your digital Student ID Card is available. You can print this out or keep it on your device.</p>
                    
                    <a href="{{ route('student.documents.id_card.download') }}" class="btn btn-lg btn-success px-5" target="_blank">
                        <i class="bi bi-download me-2"></i> Download PDF
                    </a>
                </div>
                
                <hr>
                
                <div class="p-4 bg-light rounded">
                    <h5 class="fw-bold">Card Details</h5>
                    <div class="row mt-3">
                        <div class="col-sm-6 text-muted">Name:</div>
                        <div class="col-sm-6 fw-bold">{{ auth()->user()->name }}</div>
                        
                        <div class="col-sm-6 text-muted">ID Number:</div>
                        <div class="col-sm-6 fw-bold">{{ $student->student_number }}</div>
                        
                        <div class="col-sm-6 text-muted">Type:</div>
                        <div class="col-sm-6 fw-bold">Digital Student ID</div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
