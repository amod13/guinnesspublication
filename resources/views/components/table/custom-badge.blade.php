@props([
    'status' => null,
    'type' => null, // e.g. 'boolean', 'status', 'custom'
    'label' => null, // force custom label
])

@php
    // Normalize status
    $normalizedStatus = strtolower((string) $status);

    // If type is boolean, handle Yes/No explicitly
    if ($type === 'boolean') {
        $normalizedStatus = in_array($normalizedStatus, ['1', 'true', 'yes']) ? 'yes' : 'no';
    } else {
        $normalizedStatus = match ($normalizedStatus) {
            '1', 'true', 'active' => 'active',
            '0', 'false', 'inactive' => 'inactive',
            'blocked' => 'blocked',
            'pending' => 'pending',
            default => 'unknown',
        };
    }

    // Colors
    $color = match ($normalizedStatus) {
        'active', 'yes' => 'primary',
        'inactive', 'no' => 'secondary',
        'blocked' => 'danger',
        'pending' => 'warning',
        default => 'dark',
    };

    // Label
    $displayLabel = $label ?? ucfirst($normalizedStatus);
@endphp

<span class="amd-badge amd-badge-outline-{{ $color }}">
    {{ $displayLabel }}
</span>
