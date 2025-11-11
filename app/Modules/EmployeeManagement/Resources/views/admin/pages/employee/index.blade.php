@extends('admin.main.app')
@section('content')

    <form action="{{ route('employee.index') }}" method="GET" class="position-relative">
        {{-- Close / Cross Icon --}}
       <button type="button" class="toggle-filter-btn-close position-absolute top-0 end-0 m-3 d-none amd-btn amd-btn-danger amd-btn-square-sm" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
        {{-- Search Filters --}}
        <div id="filterCard" class="amd-fillter-card p-4 border rounded-4 mb-4 d-none">
            <div class="row g-3 align-items-end">

                {{-- Row 1: Department, Sub Department, Designation, Status --}}
                <div class="col-md-3">
                    <label for="department_id" class="form-label text-muted">Department</label>
                    <select id="department_id" name="department" class="form-select">
                        <option value="">All</option>
                        @foreach ($data['department'] as $item)
                            <option value="{{ $item['id'] }}"
                                {{ isset($data['selectedSearchField']['department']) && $data['selectedSearchField']['department'] == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="sub_department_id" class="form-label text-muted">Sub Department</label>
                    <select id="sub_department_id" name="subDepartment" class="form-select">
                        <option value="">All</option>
                        @if (!empty($data['subDepartment']))
                            @foreach ($data['subDepartment'] as $item)
                                <option value="{{ $item['id'] }}"
                                    {{ isset($data['selectedSearchField']['subDepartment']) && $data['selectedSearchField']['subDepartment'] == $item['id'] ? 'selected' : '' }}>
                                    {{ $item['name'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="designationSelect" class="form-label text-muted">Designation</label>
                    <select id="designationSelect" name="designation" class="form-select">
                        <option value="">All</option>
                        @foreach ($data['designation'] as $item)
                            <option value="{{ $item['id'] }}"
                                {{ isset($data['selectedSearchField']['designation']) && $data['selectedSearchField']['designation'] == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="statusSelect" class="form-label text-muted">Employee Status</label>
                    <select id="statusSelect" name="status" class="form-select">
                        <option value="">All</option>
                        @foreach ($data['status'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ isset($data['selectedSearchField']['status']) && $data['selectedSearchField']['status'] == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Row 2: Job Category, employment type, From Date, To Date --}}
                <div class="col-md-3">
                    <label for="jobCategorySelect" class="form-label text-muted">Job Category</label>
                    <select id="jobCategorySelect" name="jobCategory" class="form-select">
                        <option value="">All</option>
                        @foreach ($data['jobCategory'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ isset($data['selectedSearchField']['jobCategory']) && $data['selectedSearchField']['jobCategory'] == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-3">
                    <label for="employmentType" class="form-label text-muted">Employement Type</label>
                    <select id="employmentType" name="employmentType" class="form-select">
                        <option value="">All</option>
                        @foreach ($data['employmentType'] as $value => $label)
                            <option value="{{ $value }}"
                                {{ isset($data['selectedSearchField']['employmentType']) && $data['selectedSearchField']['employmentType'] == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="FromDate" class="form-label text-muted">From Date</label>
                    <input type="date" id="FromDate" name="FromDate" class="form-control"
                        value="{{ $data['selectedSearchField']['FromDate'] ?? '' }}">
                </div>

                <div class="col-md-3">
                    <label for="ToDate" class="form-label text-muted">To Date</label>
                    <input type="date" id="ToDate" name="ToDate" class="form-control"
                        value="{{ $data['selectedSearchField']['ToDate'] ?? '' }}">
                </div>


                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="Manager" class="form-label text-muted">Manager</label>
                        <input type="text" id="Manager" name="Manager" class="form-control"
                            placeholder="Reporting manager" value="{{ $data['selectedSearchField']['Manager'] ?? '' }}">
                    </div>
                    <div class="col-md-9">
                        <label for="searchInput" class="form-label text-muted">Search</label>
                        <input type="text" id="searchInput" name="search" class="form-control"
                            placeholder="Search By employee code, employee name, phone number or email address..."
                            value="{{ $data['selectedSearchField']['search'] ?? '' }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('employee.index') }}"
                            class="btn btn-outline-secondary amd-btn-small rounded-pill px-4">Reset</a>
                        <button type="submit"
                            class="amd-btn amd-btn-primary amd-btn-small rounded-pill px-4">Apply</button>
                    </div>
                </div>

            </div>
        </div>
    </form>


    {{-- data counts cards --}}
    <div class=" mt-3 mb-3">
        {{-- Corrected Data Counts Cards --}}
        <div class="amd-stats-wrapper">
            <div class="row g-3">
                <!-- Card 1: Total Employees (Wider) -->
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="amd-stat-card p-3 h-100">
                        <div class="d-flex justify-content-between h-100">
                            <!-- Left: Total -->
                            <div class="d-flex flex-column justify-content-center">
                                <i class="fas fa-users fs-5 text-primary mb-2"></i>
                                <h6 class="amd-stat-card-title">Total Employees</h6>
                                <p class="amd-stat-number mb-0 fs-5">236</p>
                            </div>
                            <!-- Right: Gender Breakdown -->
                            <div class="d-flex flex-column justify-content-center amd-stat-breakdown-list text-nowrap">
                                <div class="d-flex align-items-center mb-2 gap-2">
                                    <i class="fas fa-female fa-fw amd-icon-female"></i>
                                    <span>Female <strong class="ms-2 ">124</strong></span>
                                </div>
                                <div class="d-flex align-items-center mb-2 gap-2">
                                    <i class="fas fa-male fa-fw amd-icon-male"></i>
                                    <span>Male <strong class="ms-2">108</strong></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user fa-fw amd-icon-other"></i>
                                    <span>Other <strong class="ms-2">4</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Employment Type (Wider) -->
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="amd-stat-card p-3 h-100">
                        <div class="row h-100">
                            <!-- Left Column -->
                            <div class="col-6 d-flex flex-column justify-content-center amd-stat-breakdown-list">
                                <div class="d-flex align-items-center mb-3 gap-2">
                                    <i class="fas fa-user-clock fa-fw fs-5 amd-icon-part-time"></i>
                                    <span>Part-Time - <strong>12</strong></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user-graduate fa-fw fs-5 amd-icon-interns"></i>
                                    <span>Interns - <strong>12</strong></span>
                                </div>
                            </div>
                            <!-- Right Column -->
                            <div class="col-6 d-flex flex-column justify-content-center amd-stat-breakdown-list">
                                <div class="d-flex align-items-center mb-3 gap-2">
                                    <i class="fas fa-user-tie fa-fw fs-5 amd-icon-full-time"></i>
                                    <span>Full-Time - <strong>12</strong></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user-shield fa-fw fs-5 amd-icon-contract"></i>
                                    <span>Contract - <strong>12</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Active Members (Narrower) -->
                <div class="col-12 col-lg-6 col-xl-2">
                    <div class="amd-stat-card p-3 h-100">
                        <h6 class="amd-stat-card-title">Active Members</h6>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-user-check fs-5 amd-icon-active-members"></i>
                            <p class="amd-stat-number mb-0 fs-5">198</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Activities (Narrower) -->
                <div class="col-12 col-lg-6 col-xl-2">
                    <div class="amd-stat-card p-3 h-100">
                        <h6 class="amd-stat-card-title">Activities</h6>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-chart-simple fs-5 amd-icon-activities"></i>
                            <p class="amd-stat-number mb-0 fs-5">74</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Employee List'" :createRoute="route('employee.create.basic')" :column="true" :columnLabel="'Column Manage'" :tableId="'EmployeeListTable'"
            :createLabel="'Add New'" :isSearch="true" :isDashboard="false" />

        <div class="card-body">
            <!-- Bulk Actions will be dynamically created by JS -->

            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled"
                data-bulk-delete-url="{{ route('marketings.bulk-delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('marketings.index')" :placeholder="'Search Marketingss'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description" id="EmployeeListTable"
                    data-column-manage="true">
                    <thead class="sortable-headers">
                        <tr>
                            <th><input type="checkbox" id="select-all"
                                    class="form-check-input amd-colored-check primary"></th>
                            <th>S.N.</th>
                            <th>Employee Code</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>SubDepartment</th>
                            <th>Designation</th>
                            <th>Job Category</th>
                            <th>Employment Type</th>
                            <th>Status</th>
                            <th>Phone Number</th>
                            <th>Email Adress</th>
                            <th>Reporting Manager</th>
                            <th>Date of Joining</th>
                            <th class="no-print">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('marketings.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary"
                                        value="{{ $item['id'] }}">
                                </td>
                                <td>{{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $item['employee_code'] }}</td>
                                <td>{{ $item['full_name'] }}</td>
                                <td>{{ $item['department_name'] }}</td>
                                <td>{{ $item['sub_department_name'] ?? 'N/A' }}</td>
                                <td>{{ $item['designation_name'] }}</td>
                                <td>{{ $item['job_category'] }}</td>
                                <td>{{ $item['employment_type'] }}</td>
                                <td>
                                    @if ($item['employee_status'] == 'Active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $item['mobile_number'] }}</td>
                                <td>{{ $item['email_address'] }}</td>
                                <td>{{ $item['reporting_manager'] ?? 'N/A' }}</td>
                                <td>{{ $item['date_of_joining'] }}</td>
                                <td class="d-flex no-print">
                                    {{-- Edit Button --}}
                                    <a href="{{ route('employee.create.basic', ['employeeId' => $item['id']]) }}"
                                        class="btn btn-sm me-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- View Button --}}
                                    <a href="{{ route('employee.detail', $item['id']) }}" class="btn btn-sm ">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <x-table.pagination :records="$data['records']" />
            </div>
        </div>
    </div>

    <!-- Column Manager Modal -->
    <x-table.manage-columns-modal />
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const $departmentSelect = $('#department_id');
            const $subDepartmentSelect = $('#sub_department_id');
            const oldSubDepartmentId = $('#old_sub_department_id').val();

            // Initially disable the subdepartment dropdown
            $subDepartmentSelect.prop('disabled', true);

            function loadSubDepartments(departmentId, selectedSubDeptId = null) {
                if (!departmentId) {
                    $subDepartmentSelect.empty().append(
                        $('<option>', {
                            text: 'Select sub department',
                            disabled: true,
                            selected: true,
                        })
                    ).prop('disabled', true);
                    return;
                }

                $.ajax({
                    url: `/admin/subDepartment/getSubDepartment/${departmentId}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Clear previous options
                        $subDepartmentSelect.empty();

                        // Add default placeholder option
                        $subDepartmentSelect.append(
                            $('<option>', {
                                text: 'Select sub department',
                                disabled: true,
                                selected: true,
                            })
                        );
                        console.log(data);
                        // Add new options from server
                        $.each(data, function(index, subDept) {
                            $subDepartmentSelect.append(
                                $('<option>', {
                                    value: subDept.id,
                                    text: subDept.name,
                                    selected: selectedSubDeptId == subDept
                                        .id // select if matches old value
                                })
                            );
                        });

                        $subDepartmentSelect.prop('disabled', false);
                    },
                    error: function() {
                        alert('Unable to fetch sub departments.');
                    },
                });
            }

            // Load sub departments on page load if old department value exists
            if ($departmentSelect.val()) {
                loadSubDepartments($departmentSelect.val(), oldSubDepartmentId);
            }

            // Load sub departments when department changes
            $departmentSelect.on('change', function() {
                loadSubDepartments($(this).val());
            });
        });
    </script>
@endpush
