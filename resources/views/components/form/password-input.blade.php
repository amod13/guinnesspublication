@props(['id', 'name', 'label' => '', 'required' => false, 'value' => '', 'placeholder' => 'Password'])

<style>
    /* Custom CSS for the Password Field Component */

    /* 1. The Container (replaces input-group) */
    .custom-input-group {
        /* Use flexbox to align input and button horizontally */
        display: flex;
        width: 100%;
        position: relative;
        /* For error messages if needed */
    }

    /* 2. The Input Field (replaces form-control) */
    .custom-input {
        /* Make the input take up most of the space */
        flex-grow: 1;
        padding: 0.5rem 0.75rem;
        line-height: 1.5;
        border: 1px solid #ced4da;
        /* Light gray border */
        border-right: none;
        /* Remove right border to blend with button */
        border-radius: 0.3rem 0 0 0.3rem;
        /* Rounded corners only on the left */
        /* Ensure no focus outline issues */
        box-shadow: none;
    }

    .custom-input:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        /* Simple focus ring */
    }

    /* 3. The Toggle Button (replaces btn btn-outline-secondary) */
    .custom-toggle-btn {
        /* Button styling */
        padding: 0.5rem 0.75rem;
        border: 1px solid #ced4da;
        background-color: #e9ecef;
        /* Light background */
        color: #495057;
        /* Dark text/icon color */
        cursor: pointer;
        border-left: none;
        /* To maintain a single separator line */
        border-radius: 0 0.3rem 0.3rem 0;
        /* Rounded corners only on the right */
    }

    .custom-toggle-btn:hover {
        background-color: #dee2e6;
    }
</style>

<div class="mb-3">
    <x-form.label :for="$id" :required="$required" class="custom-form-label">{{ $label }}</x-form.label>

    <div class="custom-input-group">

        <input type="password" name="{{ $name }}" id="{{ $id }}"
            class="custom-input @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
            aria-describedby="{{ $id }}-feedback" autocomplete="current-password" value="{{ $value }}">

        <button class="custom-toggle-btn" type="button" id="toggleButton_{{ $id }}"
            onclick="togglePassword('{{ $id }}', 'toggleIcon_{{ $id }}')"
            aria-label="Toggle password visibility">
            <i id="toggleIcon_{{ $id }}" class="fas fa-eye"></i>
        </button>


    </div>
    @error($name)
        <div class="text-danger">{{ $message }}</div>
    @enderror

</div>

@once
    @push('scripts')
        <script>
            function togglePassword(id, iconId) {
                const input = document.getElementById(id);
                const icon = document.getElementById(iconId);

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endonce
