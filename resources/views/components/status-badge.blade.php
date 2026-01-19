@props(['status'])
@php
    $color = match(strtolower($status)) {
        'approved' => 'success',
        'rejected' => 'danger',
        'pending' => 'warning',
        'audit' => 'info',
        default => 'secondary'
    };
    $text = ($color == 'warning' || $color == 'info') ? 'text-dark' : 'text-white';
@endphp
<span {{ $attributes->merge(['class' => "badge bg-{$color} {$text} rounded-pill px-3 py-2 text-uppercase"]) }} style="font-size: 0.7rem; letter-spacing: 0.5px;">
    {{ $status }}
</span>
