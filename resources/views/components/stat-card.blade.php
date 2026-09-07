@props(['title', 'value', 'icon', 'color' => 'primary', 'badge' => null])

<div class="stat-card h-100">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <div class="stat-label">{{ $title }}</div>
            <div class="stat-value">{{ $value }}</div>
            @if ($badge)
                <div class="mt-2">
                    <span class="badge bg-{{ $color }}-subtle text-{{ $color }}">{{ $badge }}</span>
                </div>
            @endif
        </div>
        <div class="stat-icon bg-{{ $color }}-subtle text-{{ $color }}">
            <i class="bi bi-{{ $icon }}"></i>
        </div>
    </div>
</div>
