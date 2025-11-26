@props([
    'id' => 'icon',
    'name' => 'icon',
    'label' => 'Choose Icon',
    'value' => '',
])

<div class="mb-3">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>

    <div class="input-group">
        <input type="text" id="{{ $id }}" name="{{ $name }}" class="form-control"
            value="{{ $value }}" placeholder="Select an icon..." onclick="openIconPicker(this)">

        <button class="btn btn-outline-secondary" type="button"
            onclick="openIconPicker(document.getElementById('{{ $id }}'))">
            <i class="fas fa-icons"></i>
        </button>
    </div>
</div>

{{-- Load JS Once --}}
@once
    <script src="{{ asset('admin/assets/js/icon-picker.js') }}"></script>
@endonce
