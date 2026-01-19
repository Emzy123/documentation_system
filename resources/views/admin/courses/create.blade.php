@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Add New Course</div>
        <div class="card-body">
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Course Code</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Course Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="credits" class="form-label">Credits</label>
                    <input type="number" class="form-control" id="credits" name="credits" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Course</button>
            </form>
        </div>
    </div>
</div>
@endsection
