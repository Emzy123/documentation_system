@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Mark Attendance</h2>
        </div>
    </div>

    <!-- Selection Form -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.attendance.create') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Select Course to Mark</label>
                    <select name="course_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Select Course --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ (isset($selectedCourse) && $selectedCourse->id == $course->id) ? 'selected' : '' }}>
                                {{ $course->code }} - {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    @if($selectedCourse)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">
                    Marking for: <span class="text-primary">{{ $selectedCourse->name }}</span> 
                    on <span class="text-primary">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.attendance.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $selectedCourse->id }}">
                    <input type="hidden" name="attendance_date" value="{{ $date }}">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Student</th>
                                    <th class="text-center">Present</th>
                                    <th class="text-center">Absent</th>
                                    <th class="text-center">Late</th>
                                    <th class="text-center">Excused</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $student->user->name }}</div>
                                            <small class="text-muted">{{ $student->student_number }}</small>
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" name="attendances[{{ $student->id }}][status]" value="present" checked>
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" name="attendances[{{ $student->id }}][status]" value="absent">
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" name="attendances[{{ $student->id }}][status]" value="late">
                                        </td>
                                        <td class="text-center">
                                            <input type="radio" class="form-check-input" name="attendances[{{ $student->id }}][status]" value="excused">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm" name="attendances[{{ $student->id }}][remarks]" placeholder="Reson (optional)">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-save me-2"></i> Save Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
