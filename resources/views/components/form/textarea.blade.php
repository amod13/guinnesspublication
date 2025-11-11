@props(['id', 'name', 'label' => '', 'value' => '', 'placeholder' => '', 'required' => false, 'editor' => false])
<div class="form-group">
    <x-form.label :for="$id" :required="$required">{{ $label }}</x-form.label>
    <textarea id="{{ $id }}" name="{{ $name }}"
        class="form-control @if ($editor) editor @endif @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder }}" @if ($required) required @endif>{{ old($name, $value) }}</textarea>

    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
