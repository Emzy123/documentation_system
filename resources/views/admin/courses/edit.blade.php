@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Course</div>
        <div class="card-body">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="code" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="code" name="code" value="{{ $course->code }}" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $course->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" class="form-control" id="credits" name="credits" value="{{ $course->credits }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $course->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update Course</button>
            </form>
        </div>
    </div>
</div>
@endsection
