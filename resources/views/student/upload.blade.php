@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <x-card header="Upload Document">
                <form action="{{ route('student.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Document Category</label>
                        <select name="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror">
                            <option value="">Select Category...</option>
                            @foreach($categories->groupBy('group') as $group => $groupedCategories)
                                <optgroup label="{{ $group ?: 'Other' }}">
                                    @foreach($groupedCategories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label class="form-label fw-bold">File Attachment</label>
                        <input type="file" name="file" class="form-control form-control-lg @error('file') is-invalid @enderror">
                        <div class="form-text">Accepted formats: PDF, JPG, PNG. Max size: 2MB.</div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('student.dashboard') }}" class="btn btn-light btn-lg">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-cloud-arrow-up me-2"></i> Upload
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection
