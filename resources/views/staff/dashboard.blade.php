@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Staff Dashboard</h2>
            <p class="text-muted">Manage document verifications and approvals</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
             <x-stats-card title="Flagged / Risk" value="{{ $stats['flagged'] }}" icon="exclamation-triangle-fill" color="danger" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="Auto Verified" value="{{ $stats['auto_verified'] }}" icon="robot" color="info" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="Pending Manual" value="{{ $stats['pending'] }}" icon="hourglass-split" color="warning" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="Processed Today" value="0" icon="check2-all" color="success" />
        </div>
    </div>

    <!-- Students List -->
    <div class="row">
        <div class="col-12">
            <x-card header="Students Requiring Verification">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Student Name</th>
                                <th>Student ID</th>
                                <th>Pending Documents</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->student->student_id ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $pendingCount = $user->documents->where('status', 'pending')->count();
                                            $flaggedCount = $user->documents->where('status', 'flagged')->count();
                                        @endphp
                                        @if($flaggedCount > 0)
                                            <span class="badge bg-danger">{{ $flaggedCount }} Flagged</span>
                                        @endif
                                        @if($pendingCount > 0)
                                            <span class="badge bg-warning text-dark">{{ $pendingCount }} Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($flaggedCount > 0)
                                            <span class="badge rounded-pill bg-danger-subtle text-danger">Needs Review</span>
                                        @elseif($pendingCount > 0)
                                            <span class="badge rounded-pill bg-warning-subtle text-warning">Pending</span>
                                        @else
                                            <span class="badge rounded-pill bg-success-subtle text-success">Up to Date</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('staff.student.show', $user->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-folder2-open me-1"></i> View Documents
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-check-circle fs-1 d-block mb-3"></i>
                                        No pending verifications found. Good job!
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
<!-- Add some custom CSS for the avatar if needed, or rely on bootstrap classes -->
<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
@endsection
