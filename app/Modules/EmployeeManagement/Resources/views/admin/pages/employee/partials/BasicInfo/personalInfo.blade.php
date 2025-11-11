{{-- personal informtion --}}
<div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
    <div class="row g-3">
        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input id="full_name" class="form-control @error('full_name') is-invalid @enderror" name="full_name"
                value="{{ $data['personalInformation']['full_name'] ?? old('full_name') }}" required
                placeholder="Enter Full Name" />
            @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
            <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                <option value="" disabled
                    {{ is_null(old('gender')) && empty($data['personalInformation']['gender']) ? 'selected' : '' }}>
                    Select
                    Gender</option>
                @foreach ($data['gender'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('gender') == $key || (isset($data['personalInformation']['gender']) && $data['personalInformation']['gender'] == $key) ? 'selected' : '' }}>
                        {{ $value }}</option>
                @endforeach
            </select>
            @error('gender')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
            <input type="date" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                name="date_of_birth" value="{{ $data['personalInformation']['date_of_birth'] ?? old('date_of_birth') }}"
                required />
            @error('date_of_birth')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="marital_status" class="form-label">Marital Status <span class="text-danger">*</span></label>
            <select id="marital_status" name="marital_status"
                class="form-select @error('marital_status') is-invalid @enderror" required>
                <option value="" disabled
                    {{ is_null(old('marital_status')) && empty($data['personalInformation']['marital_status']) ? 'selected' : '' }}>
                    Select Marital Status</option>
                @foreach ($data['maritalStatus'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('marital_status') == $key || (isset($data['personalInformation']['marital_status']) && $data['personalInformation']['marital_status'] == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('marital_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="nationality" class="form-label">Nationality <span class="text-danger">*</span></label>
            <input id="nationality" class="form-control @error('nationality') is-invalid @enderror" name="nationality"
                value="{{ $data['personalInformation']['nationality'] ?? old('nationality') }}" required
                placeholder="Enter Nationality" />
            @error('nationality')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="citizenship_no" class="form-label">Citizenship No. <span class="text-danger">*</span></label>
            <input id="citizenship_no" class="form-control @error('citizenship_no') is-invalid @enderror"
                name="citizenship_no"
                value="{{ $data['personalInformation']['citizenship_no'] ?? old('citizenship_no') }}" required
                placeholder="Enter Citizenship Number" />
            @error('citizenship_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="issued_district" class="form-label">Issued District <span class="text-danger">*</span></label>
            <input id="issued_district" class="form-control @error('issued_district') is-invalid @enderror"
                name="issued_district"
                value="{{ $data['personalInformation']['issued_district'] ?? old('issued_district') }}" required
                placeholder="Enter Issued District" />
            @error('issued_district')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="pan_no" class="form-label">PAN No. <span class="text-danger">*</span></label>
            <input id="pan_no" class="form-control @error('pan_no') is-invalid @enderror" name="pan_no"
                value="{{ $data['personalInformation']['pan_no'] ?? old('pan_no') }}" required
                placeholder="Enter PAN Number" />
            @error('pan_no')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="blood_group" class="form-label">Blood Group <span class="text-danger">*</span></label>
            <select id="blood_group" name="blood_group" class="form-select @error('blood_group') is-invalid @enderror"
                required>
                <option value="" disabled
                    {{ is_null(old('blood_group')) && empty($data['personalInformation']['blood_group']) ? 'selected' : '' }}>
                    Select Blood Group</option>
                @foreach ($data['bloodGroup'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('blood_group') == $key || (isset($data['personalInformation']['blood_group']) && $data['personalInformation']['blood_group'] == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('blood_group')
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
            <button type="button" class="amd-btn amd-btn-primary amd-btn-small" data-next="#contact-tab">
                Next <i  class="fas fa-arrow-right"></i>
            </button>
        </div>
    </div>
</div>
