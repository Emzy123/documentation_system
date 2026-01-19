@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">My Academic Transcript</h2>
        <a href="{{ route('student.documents.transcript_download') }}" class="btn btn-success">
            <i class="bi bi-download me-2"></i> Download PDF
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            @if($grades->isEmpty())
                <p class="text-center text-muted">No academic records found.</p>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Credits</th>
                            <th>Semester</th>
                            <th>Year</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->course->code }}</td>
                            <td>{{ $grade->course->name }}</td>
                            <td>{{ $grade->course->credits }}</td>
                            <td>{{ $grade->semester }}</td>
                            <td>{{ $grade->academic_year }}</td>
                            <td>
                                <span class="badge bg-primary fs-6">{{ $grade->grade }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
