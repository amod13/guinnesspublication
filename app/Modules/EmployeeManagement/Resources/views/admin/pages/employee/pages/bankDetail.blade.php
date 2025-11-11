@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="amd-soft-empl-container-custom">

            @include('employeemanagement::admin.pages.employee.partials._navBar')


            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container my-5">
                    @php
                        $isEditing =
                            isset($data['bankDetail']) &&
                            is_array($data['bankDetail']) &&
                            !empty($data['bankDetail']['id']);

                        $hasBankList = isset($data['bankList']) && count($data['bankList']) > 0;
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate
                        action="{{ $isEditing
                            ? route('employee.update.bank', [$data['bankDetail']['id'], $data['employeeId']])
                            : route('employee.store.bank', $data['employeeId']) }}"
                        method="POST">
                        @csrf

                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item active">
                                <button class="nav-link active" id="work-tab" data-bs-toggle="tab"
                                    data-bs-target="#bankDetail" type="button" role="tab">
                                    Bank Detail
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4">
                            <div class="tab-pane fade show active" id="work" role="tabpanel"
                                aria-labelledby="work-tab">
                                <div id="education-rows">
                                    {{-- <div class="education-row row g-3"> --}}
                                    <div class="row">

                                        {{-- salary --}}
                                        <div class="col-4">
                                            <label class="form-label">Basic Salary</label>
                                            <input type="number"
                                                class="form-control @error('basic_salary') is-invalid @enderror"
                                                name="basic_salary"
                                                value="{{ old('basic_salary', $data['bankDetail']['basic_salary'] ?? '') }}"
                                                placeholder="e.g., 50000" required />
                                            @error('basic_salary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- allowance --}}
                                        <div class="col-4">
                                            <label class="form-label">Allowances</label>
                                            <input type="number"
                                                class="form-control @error('allowances') is-invalid @enderror"
                                                name="allowances"
                                                value="{{ old('allowances', $data['bankDetail']['allowances'] ?? '') }}"
                                                placeholder="e.g., 5000" required />
                                            @error('allowances')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- deduction --}}
                                        <div class="col-4">
                                            <label class="form-label">Deductions</label>
                                            <input type="number"
                                                class="form-control @error('deductions') is-invalid @enderror"
                                                name="deductions"
                                                value="{{ old('deductions', $data['bankDetail']['deductions'] ?? '') }}"
                                                placeholder="e.g., 1500" required />
                                            @error('deductions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row g-3 mt-1">
                                        {{-- bank name --}}
                                        <div class="col-4">
                                            <label class="form-label">Bank Name</label>
                                            <input type="text"
                                                class="form-control @error('bank_name') is-invalid @enderror"
                                                name="bank_name"
                                                value="{{ old('bank_name', $data['bankDetail']['bank_name'] ?? '') }}"
                                                placeholder="e.g., Nabil Bank" required />
                                            @error('bank_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- bank account number --}}
                                        <div class="col-4">
                                            <label class="form-label">Bank Account Number</label>
                                            <input type="text"
                                                class="form-control @error('bank_account_number') is-invalid @enderror"
                                                name="bank_account_number"
                                                value="{{ old('bank_account_number', $data['bankDetail']['bank_account_number'] ?? '') }}"
                                                placeholder="e.g., 12345678901234" required />
                                            @error('bank_account_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- provident fund --}}
                                        <div class="col-4">
                                            <label class="form-label">Provident Fund No.</label>
                                            <input type="text"
                                                class="form-control @error('provident_fund_no') is-invalid @enderror"
                                                name="provident_fund_no"
                                                value="{{ old('provident_fund_no', $data['bankDetail']['provident_fund_no'] ?? '') }}"
                                                placeholder="e.g., PF123456" required />
                                            @error('provident_fund_no')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="row g-3 mt-1">
                                        {{-- status --}}
                                        <div class="col-4">
                                            <label for="status" class="form-label text-muted">Status</label>
                                            <select id="status" name="status"
                                                class="form-select @error('status') is-invalid @enderror" required>
                                                <option value=""
                                                    {{ is_null(old('status')) && empty($data['bankDetail']['status']) ? 'selected' : '' }}>
                                                    -- Select Status --</option>
                                                @foreach ($data['status'] as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ old('status', $data['bankDetail']['status'] ?? '') == $key ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    @if ($isEditing)
                                        <button type="submit" class="amd-btn amd-btn-primary amd-btn-small">Update</button>
                                        <a href="" class="amd-btn amd-btn-danger amd-btn-small ms-2">
                                            Reset
                                        </a>
                                    @elseif (!$hasBankList)
                                        <button class="amd-btn amd-btn-primary amd-btn-small" type="submit">
                                            <i class="fas fa-paper-plane"></i> Submit
                                        </button>
                                    @else
                                        <button class="amd-btn amd-btn-primary amd-btn-small" type="submit">
                                            <i class="fas fa-paper-plane"></i> Add
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </form>



                    {{-- datatable --}}
                    <div class="row p-4">
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <!-- Header with title and Add button -->
                                    <div
                                        class="amd-soft-table-header p-3 d-flex justify-content-between align-items-center">
                                        <h3 class="card-title mb-0 text-black">Bank Details</h3>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="amd-soft-table-wrapper" tabindex="0" aria-label="Data table container">
                                    <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Basic salary</th>
                                                <th>Allowances</th>
                                                <th>Deductions</th>
                                                <th>Bank Name</th>
                                                <th>Bank Account Number</th>
                                                <th>Provident Fund No</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['bankList']) && count($data['bankList']) > 0)
                                                @foreach ($data['bankList'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item['basic_salary'] }}</td>
                                                        <td>{{ $item['allowances'] }}</td>
                                                        <td>{{ $item['deductions'] }}</td>
                                                        <td>{{ $item['bank_name'] }}</td>
                                                        <td>{{ $item['bank_account_number'] }}</td>
                                                        <td>{{ $item['provident_fund_no'] }}</td>
                                                        {{-- <td>{{ ucfirst($item['status']) }}</td> --}}
                                                        <td>
                                                            @if ($item['status'])
                                                                <span class="badge bg-success">Active</span>
                                                            @else
                                                                <span class="badge bg-secondary">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td class="d-flex">

                                                            <a href="{{ route('employee.edit.bank', ['employeeId' => $data['employeeId'], 'id' => $item['id']]) }}"
                                                                class="btn btn-sm  me-2" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('employee.delete.bank', ['employeeId' => $data['employeeId'], 'id' => $item['id']]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this bank record?');"
                                                                class="me-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm "
                                                                    title="Delete">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No bank details available.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    <div class="mt-3">
                @include('employeemanagement::includes.pagination')
                                    </div>
                                </div>

                                @if (isset($data['bankList']) && count($data['bankList']) > 0)
                                    <form action="#">
                                        <div class="me-auto text-end pb-2 pt-4">
                                            <button class="amd-btn amd-btn-primary amd-btn-small">Next step <i class="fas fa-arrow-right"></i></button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </div>
@endsection
