{{-- contact information --}}
<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="row g-3">
        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
            <input type="tel" id="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror"
                name="mobile_number" pattern="^\d{10}$" required placeholder="Enter 10-digit Mobile Number"
                value="{{ $data['contactInformation']['mobile_number'] ?? old('mobile_number') }}" />
            <small class="form-text text-muted">Only digits, 10 characters.</small>
            @error('mobile_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="email_address" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" id="email_address" class="form-control @error('email_address') is-invalid @enderror"
                name="email_address" required placeholder="Enter Email Address"
                value="{{ $data['contactInformation']['email_address'] ?? old('email_address') }}" />
            @error('email_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="permanent_address" class="form-label">Permanent Address <span
                    class="text-danger">*</span></label>
            <textarea id="permanent_address" class="form-control @error('permanent_address') is-invalid @enderror"
                name="permanent_address" required rows="2" placeholder="Enter Permanent Address">{{ $data['contactInformation']['permanent_address'] ?? old('permanent_address') }}</textarea>
            @error('permanent_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="temporary_address" class="form-label">Temporary Address <span
                    class="text-danger">*</span></label>
            <textarea id="temporary_address" class="form-control @error('temporary_address') is-invalid @enderror"
                name="temporary_address" required rows="2" placeholder="Enter Temporary Address">{{ $data['contactInformation']['temporary_address'] ?? old('temporary_address') }}</textarea>
            @error('temporary_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="emergency_contact_name" class="form-label">Emergency Contact Name
                <span class="text-danger">*</span></label>
            <input id="emergency_contact_name"
                class="form-control @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name"
                required placeholder="Enter Emergency Contact Name"
                value="{{ $data['contactInformation']['emergency_contact_name'] ?? old('emergency_contact_name') }}" />
            @error('emergency_contact_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="emergency_contact_number" class="form-label">Emergency Contact Number
                <span class="text-danger">*</span></label>
            <input type="tel" id="emergency_contact_number"
                class="form-control @error('emergency_contact_number') is-invalid @enderror"
                name="emergency_contact_number" pattern="^\d{10}$" required placeholder="Enter Emergency Contact Number"
                value="{{ $data['contactInformation']['emergency_contact_number'] ?? old('emergency_contact_number') }}" />
            <small class="form-text text-muted">Only digits, 10 characters.</small>
            @error('emergency_contact_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="relationship" class="form-label">Relationship <span class="text-danger">*</span></label>
            <select id="relationship" name="relationship"
                class="form-select @error('relationship') is-invalid @enderror" required>
                <option value=""
                    {{ is_null(old('relationship')) && empty($data['contactInformation']['relationship']) ? 'selected' : '' }}>
                    Select Relationship
                </option>
                @foreach ($data['relationship'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('relationship') == $key || (isset($data['contactInformation']['relationship']) && $data['contactInformation']['relationship'] == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('relationship')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


   
     <div class=" mt-4 d-flex gap-3 pt-4" style="float:right;">
        @if ($isEdit)
            <div class="">
                <button type="submit" class="amd-btn amd-btn-primary amd-btn-small">
                    Update
                </button>
            </div>
        @endif
         <div class="">
            <button type="button" class="amd-btn amd-btn-primary amd-btn-small" data-next="#employment-tab">
                Next <i  class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>
