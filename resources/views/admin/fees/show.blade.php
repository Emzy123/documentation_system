@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.fees.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
            <div class="d-flex justify-content-between align-items-center">
                <h2>Fee Details: {{ $fee->type }}</h2>
                <span class="badge fs-5 rounded-pill 
                    {{ $fee->status === 'paid' ? 'bg-success' : 
                       ($fee->status === 'partial' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($fee->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Details Card -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white fw-bold">Information</div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted" style="width: 120px;">Student:</td>
                            <td class="fw-bold">{{ $fee->student->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Student ID:</td>
                            <td>{{ $fee->student->student_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Due Date:</td>
                            <td>{{ $fee->due_date->format('F d, Y') }}</td>
                        </tr>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr>
                            <td class="text-muted">Total Amount:</td>
                            <td class="fs-5">{{ number_format($fee->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paid:</td>
                            <td class="fs-5 text-success">{{ number_format($fee->paid_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Balance:</td>
                            <td class="fs-5 text-danger fw-bold">{{ number_format($fee->balance, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white fw-bold">Record Payment</div>
                <div class="card-body">
                    @if($fee->balance > 0)
                        <form action="{{ route('admin.fees.payments.store', $fee) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="amount" class="form-control" max="{{ $fee->balance }}" required>
                                </div>
                                <div class="form-text">Max payble: {{ number_format($fee->balance, 2) }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Date</label>
                                <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Method</label>
                                <select name="method" class="form-select" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Online">Online</option>
                                    <option value="Check">Check</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Reference (Optional)</label>
                                <input type="text" name="reference_number" class="form-control" placeholder="e.g. Receipt #123">
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-cash-coin me-2"></i> Record Payment
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success text-center">
                            <i class="bi bi-check-circle-fill fs-1"></i><br>
                            This fee is fully paid.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">Payment History</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fee->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td class="fw-bold text-success">{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->method }}</td>
                            <td>{{ $payment->reference_number ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-muted">No payments recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
