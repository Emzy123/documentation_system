@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark mb-4">My Fees & Payments</h2>
            
            <div class="row g-4 mb-4">
                <div class="col-12 col-md-4">
                    <x-stats-card title="Total Billed" value="{{ number_format($fees->sum('amount'), 2) }}" icon="receipt" color="primary" />
                </div>
                <div class="col-12 col-md-4">
                    <x-stats-card title="Total Paid" value="{{ number_format($fees->sum('paid_amount'), 2) }}" icon="wallet2" color="success" />
                </div>
                <div class="col-12 col-md-4">
                    <x-stats-card title="Outstanding Balance" value="{{ number_format($fees->sum('balance'), 2) }}" icon="exclamation-circle" color="danger" />
                </div>
            </div>
        </div>
    </div>

    @forelse($fees as $fee)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-primary">{{ $fee->type }}</h5>
                <span class="badge rounded-pill 
                    {{ $fee->status === 'paid' ? 'bg-success' : 
                       ($fee->status === 'partial' ? 'bg-warning text-dark' : 'bg-danger') }}">
                    {{ ucfirst($fee->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-md-3 border-end mb-3 mb-md-0">
                        <small class="text-muted d-block uppercase">Due Date</small>
                        <span class="fs-5">{{ $fee->due_date->format('M d, Y') }}</span>
                    </div>
                    <div class="col-6 col-md-3 border-end mb-3 mb-md-0">
                        <small class="text-muted d-block uppercase">Amount</small>
                        <span class="fs-5">{{ number_format($fee->amount, 2) }}</span>
                    </div>
                    <div class="col-6 col-md-3 border-end mb-3 mb-md-0">
                        <small class="text-muted d-block uppercase">Paid</small>
                        <span class="fs-5 text-success">{{ number_format($fee->paid_amount, 2) }}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-muted d-block uppercase">Balance</small>
                        <span class="fs-5 text-danger fw-bold">{{ number_format($fee->balance, 2) }}</span>
                    </div>
                </div>

                @if($fee->status !== 'paid')
                    <div class="mt-3 text-end boundary-pay-btn">
                        <form action="{{ route('student.fees.pay', $fee) }}" method="POST" onsubmit="return confirm('Are you sure you want to pay {{ number_format($fee->balance, 2) }} now?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-credit-card-2-front me-2"></i> Pay Now
                            </button>
                        </form>
                    </div>
                @endif

                @if($fee->payments->count() > 0)
                    <div class="mt-4">
                        <h6 class="text-muted border-bottom pb-2">Payment History</h6>
                        <table class="table table-sm text-muted">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fee->payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td>{{ $payment->method }}</td>
                                        <td>{{ $payment->reference_number ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-wallet2 display-1 text-muted"></i>
            <p class="mt-3 lead text-muted">No fee records found.</p>
        </div>
    @endforelse
</div>
@endsection
