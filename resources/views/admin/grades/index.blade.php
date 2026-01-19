@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Gradebook</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Assign Grade</div>
                <div class="card-body">
                    <form action="{{ route('admin.grades.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-control" id="student_id" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->user->name ?? $student->student_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-control" id="course_id" name="course_id" required>
                                <option value="">Select Course</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <input type="text" class="form-control" name="academic_year" placeholder="2023-2024" required>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" name="semester" required>
                                <option value="1st">1st Semester</option>
                                <option value="2nd">2nd Semester</option>
                                <option value="Summer">Summer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="grade" class="form-label">Grade</label>
                            <input type="text" class="form-control" name="grade" placeholder="e.g. 1.0, 95, A" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Assign Grade</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Student Records</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Grade</th>
                                <th>Sem/Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                @foreach($student->grades as $grade)
                                <tr>
                                    <td>{{ $student->user->name ?? $student->student_number }}</td>
                                    <td>{{ $grade->course->code }}</td>
                                    <td>{{ $grade->grade }}</td>
                                    <td>{{ $grade->semester }} {{ $grade->academic_year }}</td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
