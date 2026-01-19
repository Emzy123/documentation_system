@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
            <h2 class="fw-bold text-dark">{{ $user->name }}</h2>
            <p class="text-muted">{{ $user->role->name ?? 'No Role' }} | {{ $user->email }}</p>
        </div>
    </div>

    <div class="row">
        <!-- Student Information -->
        <div class="col-md-4">
             <x-card header="Profile Details">
                @if($user->student)
                    <dl class="row">
                        <dt class="col-sm-5 text-muted">Student No</dt>
                        <dd class="col-sm-7 fw-bold">{{ $user->student->student_number ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Program</dt>
                        <dd class="col-sm-7">{{ $user->student->program ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Phone</dt>
                        <dd class="col-sm-7">{{ $user->student->phone ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Address</dt>
                        <dd class="col-sm-7 small">{{ $user->student->address ?? 'N/A' }}</dd>
                    </dl>
                @else
                    <p class="text-muted">No student profile data available.</p>
                @endif
             </x-card>
             
             <!-- Generated Documents -->
             <x-card header="Official Documents" class="mt-4">
                 @if($user->student && $user->student->generatedDocuments->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($user->student->generatedDocuments as $genDoc)
                            <a href="{{ Storage::url($genDoc->file_path) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="bi bi-file-earmark-pdf-fill text-danger me-2"></i>
                                    {{ $genDoc->type }}
                                </div>
                                <small class="text-muted">{{ $genDoc->created_at->format('d M Y') }}</small>
                            </a>
                        @endforeach
                    </div>
                 @else
                    <p class="text-muted small">No official documents generated yet.</p>
                 @endif
             </x-card>
        </div>

        <!-- Documents & Verification -->
        <div class="col-md-8">
            <x-card header="Document History">
                @if($user->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Verification Log</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->documents as $doc)
                                    <tr>
                                        <td>
                                            <span class="fw-bold d-block">{{ $doc->title }}</span>
                                            <small class="text-muted">{{ $doc->category->name }}</small>
                                        </td>
                                        <td><x-status-badge :status="$doc->status" /></td>
                                        <td>
                                            @if($doc->verificationLogs->count() > 0)
                                                <ul class="list-unstyled small mb-0">
                                                    @foreach($doc->verificationLogs->take(3) as $log)
                                                        <li>
                                                            <span class="fw-bold text-dark">{{ $log->new_status }}</span>
                                                            @if($log->remarks)
                                                                <span class="text-muted">- {{ Str::limit($log->remarks, 30) }}</span>
                                                            @endif
                                                            <i class="text-muted ms-1">({{ $log->created_at->format('d M') }})</i>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">No documents uploaded.</p>
                @endif
            </x-card>
        </div>
    </div>
</div>
@endsection
