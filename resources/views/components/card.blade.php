<div {{ $attributes->merge(['class' => 'card shadow-sm border-0']) }}>
    @if(isset($header))
    <div class="card-header bg-white border-bottom-0 py-3">
        <h5 class="mb-0 fw-bold text-primary">{{ $header }}</h5>
    </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
