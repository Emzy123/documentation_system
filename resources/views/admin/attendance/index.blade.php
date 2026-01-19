@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark">Attendance Records</h2>
            <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                <i class="bi bi-clock-history me-2"></i> Mark Attendance
            </a>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.attendance.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter by Course</label>
                    <select name="course_id" class="form-select">
                        <option value="">All Courses</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->code }} - {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="attendance_date" class="form-control" value="{{ request('attendance_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive bg-white rounded shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->attendance_date->format('M d, Y') }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $attendance->student->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $attendance->student->student_number ?? '' }}</small>
                        </td>
                        <td>{{ $attendance->course->code ?? 'N/A' }}</td>
                        <td>
                            <span class="badge rounded-pill 
                                {{ $attendance->status === 'present' ? 'bg-success' : 
                                   ($attendance->status === 'absent' ? 'bg-danger' : 
                                   ($attendance->status === 'late' ? 'bg-warning text-dark' : 'bg-info text-dark')) }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ $attendance->remarks }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
