@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold text-dark">System Reports</h2>
        <p class="text-muted">Audit trail and system activity logs</p>
    </div>

    <!-- Stats Summary (Optional) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <x-stats-card title="Total Audits" value="{{ $audits->total() }}" icon="shield-check" color="info" />
        </div>
        <div class="col-md-6">
            <x-stats-card title="Total Activities" value="{{ $logs->total() }}" icon="activity" color="primary" />
        </div>
    </div>

    <div class="row">
        <!-- Document Audit Trail -->
        <div class="col-md-12 mb-5">
            <x-card header="Document Audit Trail">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase small fw-bold text-muted">Time</th>
                                <th class="text-uppercase small fw-bold text-muted">User</th>
                                <th class="text-uppercase small fw-bold text-muted">Document</th>
                                <th class="text-uppercase small fw-bold text-muted">Action</th>
                                <th class="text-uppercase small fw-bold text-muted">Status Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audits as $audit)
                            <tr>
                                <td class="text-muted">{{ $audit->created_at->format('M d H:i') }}</td>
                                <td class="fw-bold small">{{ $audit->user->name }}</td>
                                <td>
                                    <span class="d-block text-truncate" style="max-width: 200px;" title="{{ $audit->document->title ?? 'Deleted' }}">
                                        {{ $audit->document->title ?? 'Deleted Document' }}
                                    </span>
                                </td>
                                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">Updated Status</span></td>
                                <td>
                                    <span class="badge bg-secondary text-white" style="font-size: 0.7em;">{{ $audit->previous_status }}</span>
                                    <i class="bi bi-arrow-right mx-1 small text-muted"></i>
                                    <x-status-badge :status="$audit->new_status" />
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No audit records found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $audits->appends(['logs_page' => $logs->currentPage()])->links() }}
                </div>
            </x-card>
        </div>

        <!-- System Activity Logs -->
        <div class="col-md-12">
            <x-card header="General Activity Logs">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-uppercase small fw-bold text-muted">Time</th>
                                <th class="text-uppercase small fw-bold text-muted">User</th>
                                <th class="text-uppercase small fw-bold text-muted">Action</th>
                                <th class="text-uppercase small fw-bold text-muted">Details</th>
                                <th class="text-uppercase small fw-bold text-muted">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="text-muted">{{ $log->created_at->format('M d H:i') }}</td>
                                <td class="fw-bold small">{{ $log->user->name }}</td>
                                <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $log->action }}</span></td>
                                <td class="text-muted small">{{ Str::limit($log->details, 60) }}</td>
                                <td class="small text-muted font-monospace">{{ $log->ip_address }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No activity logs found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $logs->appends(['audits_page' => $audits->currentPage()])->links() }}
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection
