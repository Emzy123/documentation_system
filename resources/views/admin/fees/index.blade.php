@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark">Fee Management</h2>
            <a href="{{ route('admin.fees.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i> Assign Fee
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <form action="{{ route('admin.fees.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="student_number" class="form-control" placeholder="Search by Student ID" value="{{ request('student_number') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive bg-white rounded shadow-sm p-3">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Student</th>
                    <th>Type</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $fee->student->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $fee->student->student_number }}</small>
                        </td>
                        <td>{{ $fee->type }}</td>
                        <td>{{ $fee->due_date->format('M d, Y') }}</td>
                        <td>{{ number_format($fee->amount, 2) }}</td>
                        <td class="text-success">{{ number_format($fee->paid_amount, 2) }}</td>
                        <td class="text-danger fw-bold">{{ number_format($fee->balance, 2) }}</td>
                        <td>
                            <span class="badge rounded-pill 
                                {{ $fee->status === 'paid' ? 'bg-success' : 
                                   ($fee->status === 'partial' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($fee->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.fees.show', $fee) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No fee records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $fees->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
