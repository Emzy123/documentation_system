@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Verify Document</h2>
        <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    <div class="row">
        <!-- Document Details -->
        <div class="col-md-7">
            <x-card header="Document Information">
                <table class="table table-borderless">
                    <tr>
                        <th class="ps-0 text-muted w-25">Student Name:</th>
                        <td class="fw-bold fs-5">{{ $document->user->name }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0 text-muted">Email:</th>
                        <td>{{ $document->user->email }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0 text-muted">Category:</th>
                        <td><span class="badge bg-info bg-opacity-10 text-info">{{ $document->category->name }}</span></td>
                    </tr>
                    <tr>
                        <th class="ps-0 text-muted">Title:</th>
                        <td>{{ $document->title }}</td>
                    </tr>
                    <tr>
                        <th class="ps-0 text-muted">Current Status:</th>
                        <td><x-status-badge :status="$document->status" /></td>
                    </tr>
                    <tr>
                        <th class="ps-0 text-muted">Uploaded:</th>
                        <td>{{ $document->created_at->format('F d, Y h:i A') }}</td>
                    </tr>
                </table>

                <div class="mt-4 p-4 bg-light rounded-3 text-center border dashed">
                    <p class="mb-3 text-muted">Click below to view the attached file</p>
                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bi bi-file-earmark-pdf me-2"></i> View Document
                    </a>
                </div>
            </x-card>
        </div>

        <!-- Action Panel -->
        <div class="col-md-5">
            <x-card header="Verification Action">
                <form action="{{ route('staff.documents.update', $document->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Action</label>
                        <select name="status" class="form-select form-select-lg" id="statusSelect">
                            <option value="approved">Approve Document</option>
                            <option value="rejected">Reject Document</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="4" placeholder="Add comments (required for rejection)..."></textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i> Submit Verification
                        </button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
@endsection
