{{-- employee details --}}
<div class="tab-pane fade " id="employment" role="tabpanel" aria-labelledby="employment-tab">
    <div class="row g-3">
        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="date_of_joining" class="form-label">Date of Joining <span class="text-danger">*</span></label>
            <input type="date" id="date_of_joining"
                class="form-control @error('date_of_joining') is-invalid @enderror" name="date_of_joining" required
                value="{{ $data['employeeDetail']['date_of_joining'] ?? old('date_of_joining') }}" />
            @error('date_of_joining')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
            <select id="department_id" name="department_id"
                class="form-select @error('department_id') is-invalid @enderror" required>
                <option value=""
                    {{ is_null(old('department_id')) && empty($data['employeeDetail']['department_id']) ? 'selected' : '' }}>
                    Select department</option>
                @foreach ($data['department'] as $item)
                    <option value="{{ $item['id'] }}"
                        {{ old('department_id') == $item['id'] || (isset($data['employeeDetail']['department_id']) && $data['employeeDetail']['department_id'] == $item['id']) ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="sub_department_id" class="form-label">Sub Department </label>
            <select id="sub_department_id" name="sub_department_id"
                class="form-select @error('sub_department_id') is-invalid @enderror">
                <option value=""
                    {{ is_null(old('sub_department_id')) && empty($data['employeeDetail']['sub_department_id']) ? 'selected' : '' }}>
                    Select sub department
                </option>
            </select>
            <input type="hidden" id="old_sub_department_id"
                value="{{ old('sub_department_id', $data['employeeDetail']['sub_department_id'] ?? '') }}">
        </div>


        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="designation_id" class="form-label">Designation <span class="text-danger">*</span></label>
            <select id="designation_id" name="designation_id"
                class="form-select @error('designation_id') is-invalid @enderror" required>
                <option value=""
                    {{ is_null(old('designation_id')) && empty($data['employeeDetail']['designation_id']) ? 'selected' : '' }}>
                    Select designation</option>
                @foreach ($data['designation'] as $item)
                    <option value="{{ $item['id'] }}"
                        {{ old('designation_id') == $item['id'] || (isset($data['employeeDetail']['designation_id']) && $data['employeeDetail']['designation_id'] == $item['id']) ? 'selected' : '' }}>
                        {{ $item['name'] }}
                    </option>
                @endforeach
            </select>
            @error('designation_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="employment_type" class="form-label">Employment Type <span class="text-danger">*</span></label>
            <select id="employment_type" name="employment_type"
                class="form-select @error('employment_type') is-invalid @enderror" required>
                <option value=""
                    {{ is_null(old('employment_type')) && empty($data['employeeDetail']['employment_type']) ? 'selected' : '' }}>
                    Select Employment Type
                </option>
                @foreach ($data['employmentType'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('employment_type') == $key || (isset($data['employeeDetail']['employment_type']) && $data['employeeDetail']['employment_type'] == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('employment_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="job_category" class="form-label">Job Category <span class="text-danger">*</span></label>
            <select id="job_category" name="job_category"
                class="form-select @error('job_category') is-invalid @enderror" required>
                <option value=""
                    {{ is_null(old('job_category')) && empty($data['employeeDetail']['job_category']) ? 'selected' : '' }}>
                    Select Job Category</option>
                @foreach ($data['jobCategory'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ old('job_category') == $key || (isset($data['employeeDetail']['job_category']) && $data['employeeDetail']['job_category'] == $key) ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('job_category')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="employee_status" class="form-label">Employee Status <span class="text-danger">*</span></label>
            <select id="employee_status" name="employee_status"
                class="form-select @error('employee_status') is-invalid @enderror" required>
                @php
                    $currentStatus = old('employee_status') ?? ($data['employeeDetail']['employee_status'] ?? '');
                @endphp

                <option value="" {{ $currentStatus === '' ? 'selected' : '' }}>Select Status</option>
                @foreach ($data['status'] as $key => $value)
                    <option value="{{ $key }}"
                        {{ (string) $currentStatus === (string) $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            @error('employee_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 amd-soft-empl-input-with-icon">
            <label for="reporting_manager" class="form-label">Reporting Manager </label>
            <input id="reporting_manager" class="form-control @error('reporting_manager') is-invalid @enderror"
                name="reporting_manager"
                value="{{ $data['employeeDetail']['reporting_manager'] ?? old('reporting_manager') }}"
                placeholder="Enter Reporting Manager" />
            @error('reporting_manager')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Date of Leaving --}}
        <div class="col-md-6 amd-soft-empl-input-with-icon" id="date_of_leaving_wrapper"
            style="{{ $currentStatus !== 'inactive' ? 'display:none;' : '' }}">
            <label for="date_of_leaving" class="form-label">Date of Leaving <span class="text-danger">*</span></label>
            <input type="date" id="date_of_leaving"
                class="form-control @error('date_of_leaving') is-invalid @enderror" name="date_of_leaving"
                value="{{ $data['employeeDetail']['date_of_leaving'] ?? old('date_of_leaving') }}" />
            @error('date_of_leaving')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class=" mt-4 d-flex gap-3 pt-4" style="float:right;">
        <button type="submit" class="{{ $isEdit ? 'amd-btn amd-btn-primary amd-btn-small' : 'btn btn-success' }}">
            {{ $isEdit ? 'Update' : 'Submit' }}
        </button>
    </div>

    <div>

    </div>
</div>
