@props(['title', 'value', 'icon', 'color' => 'primary'])
<div class="card border-0 shadow-sm h-100">
    <div class="card-body d-flex align-items-center">
        <div class="rounded-circle bg-{{ $color }} bg-opacity-10 p-3 me-3 text-{{ $color }}">
            <i class="bi bi-{{ $icon }} fs-3"></i>
        </div>
        <div>
            <h6 class="text-muted mb-1 text-uppercase small fw-bold">{{ $title }}</h6>
            <h3 class="mb-0 fw-bold text-dark">{{ $value }}</h3>
        </div>
    </div>
</div>
