@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Admin Overview</h2>
            <p class="text-muted">System statistics and management</p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <x-stats-card title="Total Users" value="{{ $usersCount }}" icon="people" color="primary" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="Total Documents" value="{{ $documentsCount }}" icon="file-earmark-text" color="info" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="Pending Review" value="{{ $pendingCount }}" icon="hourglass-split" color="warning" />
        </div>
        <div class="col-md-3">
            <x-stats-card title="System Health" value="100%" icon="activity" color="success" />
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <x-card header="Quick Actions">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-person-gear me-2 text-primary"></i>
                            Manage Users
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-tags me-2 text-primary"></i>
                            Manage Categories
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i>
                            View Reports
                        </div>
                        <i class="bi bi-chevron-right text-muted small"></i>
                    </a>
                </div>
            </x-card>
        </div>
        
        <div class="col-md-6">
             <x-card header="Recent System Activity">
                 <div class="text-center py-5 text-muted">
                     <i class="bi bi-hdd-stack fs-1 d-block mb-3"></i>
                     Activity logs will appear here.
                 </div>
             </x-card>
        </div>
    </div>
</div>
@endsection
