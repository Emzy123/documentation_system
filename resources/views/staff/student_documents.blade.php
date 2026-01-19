@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('staff.dashboard') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold text-dark">{{ $user->name }}'s Documents</h2>
                    <p class="text-muted">Student ID: {{ $user->student->student_id ?? 'N/A' }} | Email: {{ $user->email }}</p>
                </div>
                <div>
                    <span class="badge bg-primary fs-6">{{ $user->documents->count() }} Documents</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @foreach($user->documents as $document)
                <div class="card mb-3 shadow-sm {{ $document->status === 'flagged' ? 'border-danger' : 'border-0' }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Icon -->
                            <div class="col-auto">
                                <div class="bg-light rounded p-3 text-center" style="width: 60px;">
                                    <i class="bi bi-file-earmark-text fs-3 text-secondary"></i>
                                </div>
                            </div>
                            
                            <!-- Info -->
                            <div class="col-md-5">
                                <h5 class="mb-1 fw-bold">
                                    {{ $document->title }} 
                                    @if($document->status === 'flagged')
                                        <i class="bi bi-exclamation-triangle-fill text-danger ms-2" title="Flagged by System"></i>
                                    @elseif($document->status === 'auto_verified')
                                        <i class="bi bi-robot text-info ms-2" title="Auto Verified"></i>
                                    @endif
                                </h5>
                                <p class="mb-0 text-muted small">Category: {{ $document->category->name }}</p>
                                <p class="mb-0 text-muted small">Uploaded: {{ $document->created_at->format('M d, Y h:i A') }}</p>
                            </div>

                            <!-- Status Badge -->
                            <div class="col-md-2 text-md-center my-2 my-md-0">
                                <x-status-badge :status="$document->status" />
                            </div>

                            <!-- Actions -->
                            <div class="col-md-4 text-md-end">
                                <div class="btn-group">
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> View File
                                    </a>
                                    @if($document->status !== 'approved')
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $document->id }}">
                                        <i class="bi bi-check-lg"></i> Approve
                                    </button>
                                    @endif
                                    @if($document->status !== 'rejected')
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $document->id }}">
                                        <i class="bi bi-x-lg"></i> Reject
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- System Remarks -->
                        @if($document->remarks)
                            <div class="alert {{ $document->status === 'flagged' ? 'alert-danger' : 'alert-info' }} mt-3 mb-0 py-2">
                                <small><strong>System Remarks:</strong> {{ $document->remarks }}</small>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal{{ $document->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('staff.documents.update', $document->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <div class="modal-header">
                                    <h5 class="modal-title">Approve Document</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to approve <strong>{{ $document->title }}</strong>?</p>
                                    <div class="mb-3">
                                        <label class="form-label">Remarks (Optional)</label>
                                        <textarea name="remarks" class="form-control" placeholder="Add verification notes..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Confirm Approval</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Reject Modal -->
                <div class="modal fade" id="rejectModal{{ $document->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('staff.documents.update', $document->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <div class="modal-header">
                                    <h5 class="modal-title text-danger">Reject Document</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to reject <strong>{{ $document->title }}</strong>?</p>
                                    <div class="mb-3">
                                        <label class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                                        <textarea name="remarks" class="form-control" required placeholder="Explain why this document is rejected..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
