@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0 pt-3 pt-md-0 text-center text-md-start">
                <h2 class="fw-bold text-dark">My Dashboard</h2>
                <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="{{ route('student.documents.admission_letter') }}" class="btn btn-outline-success">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Admission Letter
                </a>
                <a href="{{ route('student.documents.id_card') }}" class="btn btn-outline-info">
                    <i class="bi bi-person-badge me-2"></i> ID Card
                </a>
                <a href="{{ route('student.documents.certificate') }}" class="btn btn-outline-warning">
                    <i class="bi bi-award me-2"></i> Certificate
                </a>
                <a href="{{ route('student.documents.create') }}" class="btn btn-primary">
                    <i class="bi bi-cloud-upload me-2"></i> Upload New
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->student && !auth()->user()->student->hasPaidSchoolFees())
        <div class="alert alert-danger border-danger border-2 d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-lock-fill fs-3 me-3"></i>
            <div>
                <h5 class="alert-heading fw-bold mb-1">Account Restriction Active</h5>
                <p class="mb-0">You have outstanding <strong>School Fees</strong> that must be paid before you can upload or request documents. <a href="{{ route('student.fees.index') }}" class="fw-bold text-danger text-decoration-underline">Make a payment now</a> to unlock these features.</p>
            </div>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-12 col-md-3 mb-3 mb-md-0">
             <div class="card border-0 shadow-sm bg-primary text-white h-100">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Documentation Status</h6>
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <span class="display-6 fw-bold">{{ $progress }}%</span>
                        <i class="bi bi-pie-chart fs-1 opacity-50"></i>
                    </div>
                    <div class="progress bg-white bg-opacity-25 mt-3" style="height: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="mt-2 d-block opacity-75">{{ $missingMandatoryCount }} Mandatory Documents Missing</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-0">
            <x-stats-card title="Total Uploads" value="{{ auth()->user()->documents()->count() }}" icon="folder" color="info" />
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-0">
            <x-stats-card title="Approved" value="{{ auth()->user()->documents()->where('status', 'approved')->count() }}" icon="check-circle" color="success" />
        </div>
        <div class="col-6 col-md-3 mb-3 mb-md-0">
            <x-stats-card title="Pending" value="{{ auth()->user()->documents()->whereIn('status', ['pending', 'auto_verified', 'flagged'])->count() }}" icon="clock" color="warning" />
        </div>
    </div>

    <!-- Document Groups Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-3">Required Documentation</h4>
            <div class="accordion" id="accordionDocuments">
                @foreach($docGroups as $groupName => $docs)
                    <div class="accordion-item shadow-sm border-0 mb-3 overflow-hidden rounded">
                        <h2 class="accordion-header" id="heading{{ Str::slug($groupName) }}">
                            <button class="accordion-button fw-bold {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($groupName) }}">
                                {{ $groupName }}
                                @php
                                    $groupTotal = count($docs);
                                    $groupUploaded = collect($docs)->where('uploaded', true)->count();
                                @endphp
                                <span class="badge bg-{{ $groupUploaded == $groupTotal ? 'success' : 'secondary' }} ms-2">
                                    {{ $groupUploaded }}/{{ $groupTotal }}
                                </span>
                            </button>
                        </h2>
                        <div id="collapse{{ Str::slug($groupName) }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#accordionDocuments">
                            <div class="accordion-body p-0">
                                <div class="list-group list-group-flush">
                                    @foreach($docs as $doc)
                                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                            <div>
                                                <div class="d-flex align-items-center mb-1">
                                                    <h6 class="mb-0 fw-bold">{{ $doc['category']->name }}</h6>
                                                    @if($doc['is_mandatory'])
                                                        <span class="badge bg-danger ms-2" style="font-size: 0.6rem;">REQUIRED</span>
                                                    @else
                                                        <span class="badge bg-secondary ms-2" style="font-size: 0.6rem;">OPTIONAL</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $doc['category']->description }}</small>
                                            </div>
                                            
                                            @if($doc['uploaded'])
                                                <span class="badge bg-success rounded-pill">
                                                    <i class="bi bi-check-lg me-1"></i> Uploaded
                                                </span>
                                            @else
                                                <a href="{{ route('student.documents.create', ['category' => $doc['category']->id]) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-upload me-1"></i> Upload
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Documents -->
    <div class="row">
        <div class="col-12">
            <x-card header="Recent Uploads">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDocuments as $doc)
                            <tr>
                                <td class="fw-bold">{{ $doc->title }}</td>
                                <td>{{ $doc->category->name }}</td>
                                <td>
                                    @if($doc->status == 'auto_verified')
                                        <span class="badge bg-info text-dark">Auto-Verified</span>
                                    @elseif($doc->status == 'flagged')
                                        <span class="badge bg-danger">Flagged</span>
                                    @else
                                        <x-status-badge :status="$doc->status" />
                                    @endif
                                    @if($doc->remarks)
                                        <i class="bi bi-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="{{ $doc->remarks }}"></i>
                                    @endif
                                </td>
                                <td>{{ $doc->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bi bi-cloud-slash fs-1 d-block mb-3"></i>
                                        You haven't uploaded any documents yet.
                                    </div>
                                    <a href="{{ route('student.documents.create') }}" class="btn btn-sm btn-outline-primary mt-3">Upload First Document</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</div>

<!-- Required Documents Modal -->
@if($progress < 100)
<div class="modal fade" id="requiredDocsModal" tabindex="-1" aria-labelledby="requiredDocsModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning bg-opacity-10 border-warning">
        <h5 class="modal-title fw-bold text-dark" id="requiredDocsModalLabel">
            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Action Required
        </h5>
      </div>
      <div class="modal-body p-4">
        <div class="mb-4">
            <p class="lead mb-1">Incomplete Documentation</p>
            <p class="text-muted">You must upload the following mandatory documents to complete your registration.</p>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">{{ $progress }}% Complete</small>
                <small class="text-danger fw-bold">{{ $missingMandatoryCount }} Remaining</small>
            </div>
        </div>

        <h6 class="fw-bold mb-3 border-bottom pb-2">Missing Mandatory Documents</h6>
        <div class="list-group mb-4">
            @foreach($docGroups as $group => $docs)
                @foreach($docs as $doc)
                    @if($doc['is_mandatory'] && !$doc['uploaded'])
                    <div class="list-group-item d-flex justify-content-between align-items-center border-start border-4 border-danger">
                        <div>
                            <span class="fw-bold">{{ $doc['category']->name }}</span>
                            <small class="d-block text-muted">{{ $doc['category']->description }}</small>
                        </div>
                        <a href="{{ route('student.documents.create', ['category' => $doc['category']->id]) }}" class="btn btn-sm btn-primary">
                            Upload <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    @endif
                @endforeach
            @endforeach
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Remind Me Later</button>
        <a href="{{ route('student.documents.create') }}" class="btn btn-primary">Start Uploading</a>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function(){
        var myModal = new bootstrap.Modal(document.getElementById('requiredDocsModal'));
        myModal.show();
    });
</script>
@endpush
@endif
@endsection
