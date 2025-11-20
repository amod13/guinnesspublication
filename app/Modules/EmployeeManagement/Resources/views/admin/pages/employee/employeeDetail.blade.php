@extends('admin.main.app')

@section('content')
    <div class="row ">
        <div class="container-fluid amd-employee-detail-bg-light ">
            <div class="row g-4 max-w-7xl mx-auto">
                <!-- Left Column -->
                <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                    <!-- Profile Card -->
                    <div class="card overflow-hidden shadow-sm">
                        <div class="amd-employee-detail-profile-header position-relative">
                            <div class="text-center my-4">
                                <h5 class="fw-bold  text-uppercase stroke-text">
                                    Employee Data
                                </h5>
                            </div>
                            <div class="amd-employee-detail-avatar-container">
                                <img src="{{ $data['officialDocument']['photo'] }}" alt="Stephan Peralt"
                                    class="amd-employee-detail-avatar">
                            </div>
                        </div>
                        <div class="card-body pt-5 pb-4 text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                <h2 class="h5 fw-bold mb-0"> {{ $data['personalInfo']['full_name'] }} <i
                                        class="fas fa-check-circle "></i></h2>
                            </div>
                            <div
                                class="d-flex flex-wrap align-items-center justify-content-center gap-2 text-sm text-muted mb-4">
                                <span
                                    class="badge bg-light text-dark rounded-pill px-2 py-1 d-inline-flex align-items-center gap-1">
                                    <i class="fa fa-level-up" aria-hidden="true"></i>
                                    {{ $data['employmentDetail']['designation_name'] }}
                                </span>
                            </div>
                            <div class="row g-3 text-sm text-start mb-4">
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fa-solid fa-user text-muted"></i>
                                    User Name
                                </div>
                                <div class="col-6 fw-medium">{{ $data['systemAccess']['username'] }}</div>
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fas fa-wallet text-muted"></i>
                                    Employee Code
                                </div>
                                <div class="col-6 fw-medium">{{ $data['personalInfo']['employee_code'] }}</div>
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fas fa-users text-muted"></i>
                                    Department
                                </div>
                                <div class="col-6 fw-medium">{{ $data['employmentDetail']['department_name'] }}</div>
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fas fa-users text-muted"></i>
                                    Sub Department
                                </div>
                                <div class="col-6 fw-medium">{{ $data['employmentDetail']['sub_department_name'] }}</div>
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fas fa-calendar-alt text-muted"></i>
                                    Date Of Join
                                </div>
                                <div class="col-6 fw-medium">{{ $data['employmentDetail']['date_of_joining'] }}</div>
                                <div class="col-6 d-flex align-items-center gap-3">
                                    <i class="fas fa-briefcase text-muted"></i>
                                    Report Manager
                                </div>

                                <div class="col-6 fw-medium d-flex align-items-center gap-3">
                                    {{ $data['employmentDetail']['reporting_manager'] }}
                                </div>
                            </div>
                            <div class="d-flex gap-3">
                                <a class="amd-btn amd-btn-primary flex-grow-1"
                                    href="{{ route('employee.create.basic', ['employeeId' => $data['personalInfo']['id']]) }}">
                                    <i class="fas fa-edit me-2"></i>
                                    Edit Info
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div class="col-12 col-lg-8 d-flex flex-column gap-4">
                    <!-- about employee -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center" role="button">

                            <div
                                class="amd-employee-tabs d-flex align-item-center text-start justify-content-start gap-3 flex-wrap">
                                <button class="amd-btn amd-btn-primary amd-btn-xs emp-info-switch active"
                                    data-value="personalInfo">
                                    personal Information
                                </button>
                                <button class="amd-btn amd-btn-primary amd-btn-xs  emp-info-switch" data-value="bankDetail">
                                    Bank information
                                </button>
                                <button class="amd-btn amd-btn-primary amd-btn-xs emp-info-switch" data-value="workDetail">
                                    Education Details
                                </button>
                                <button class="amd-btn amd-btn-primary amd-btn-xs emp-info-switch"
                                    data-value="educationDetail">
                                    Work Experience
                                </button>
                                <button class="amd-btn amd-btn-primary amd-btn-xs emp-info-switch"
                                    data-value="officialDetail">
                                    Official Document
                                </button>

                            </div>

                        </div>

                        <div class="collapse show" id="bookInfoCollapse">
                            <div class="card-body d-flex flex-column gap-4">

                                {{-- personal information --}}
                                <div class=" data-info" id="personalInfo">
                                    <div class="">
                                        <div class="card-body">

                                            <div class=" mb-3">
                                                <div class="card-body">
                                                    <!-- First Row: Key Financial Info -->
                                                    <div class="row g-4 text-sm">
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Citizenship no</div>
                                                            <div class="fw-medium">
                                                                {{ $data['personalInfo']['citizenship_no'] }}</div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Issued District</div>
                                                            <div class="fw-medium">
                                                                {{ $data['personalInfo']['issued_district'] }}</div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Pan Number</div>
                                                            <div class="fw-medium">{{ $data['personalInfo']['pan_no'] }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Blood Group</div>
                                                            <div class="fw-medium">
                                                                {{ $data['personalInfo']['blood_group'] }}</div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Nationality</div>
                                                            <div class="fw-medium">
                                                                {{ $data['personalInfo']['nationality'] }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Marital status</div>
                                                            <div class="fw-medium">
                                                                {{ $data['personalInfo']['marital_status'] }}
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Emergency Contact</div>
                                                            <div class="fw-medium">
                                                                {{ $data['contactInfo']['emergency_contact_name'] }}
                                                            </div>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted">Emergency Number</div>
                                                            <div class="fw-medium">
                                                                {{ $data['contactInfo']['emergency_contact_number'] }}
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- Bank Info -->
                                <div class=" d-none data-info" id="bankDetail">

                                    <div class="">
                                        <div class="card-body">
                                            @foreach ($data['bankDetails'] as $item)
                                                <div class=" mb-3">
                                                    <div class="card-body">
                                                        <!-- First Row: Key Financial Info -->
                                                        <div class="row g-4 text-sm">
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Bank Name</div>
                                                                <div class="fw-medium">{{ $item['bank_name'] }}</div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Basic Salary</div>
                                                                <div class="fw-medium">{{ $item['basic_salary'] }}</div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Allowances</div>
                                                                <div class="fw-medium">{{ $item['allowances'] }}</div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Deductions</div>
                                                                <div class="fw-medium">{{ $item['deductions'] }}</div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Bank Account No</div>
                                                                <div class="fw-medium">{{ $item['bank_account_number'] }}
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Provident Fund No</div>
                                                                <div class="fw-medium">{{ $item['provident_fund_no'] }}
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                <div class="text-muted">Status</div>
                                                                <div>
                                                                    @if ($item['status'] == 'Active')
                                                                        <span class="badge bg-success">Active</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">Inactive</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                </hr>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- work experience Info -->
                                <div class="d-none data-info" id="workDetail">

                                    <div class="">
                                        <div class="card-body text-muted text-sm">
                                            <div class="card-body">
                                                @foreach ($data['workExperience'] as $item)
                                                    <div class=" mb-3">
                                                        <div class="card-body">
                                                            <!-- First Row: Key Financial Info -->
                                                            <div class="row g-4 text-sm">
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Organization Name</div>
                                                                    <div class="fw-medium">
                                                                        {{ $item['organization_name'] }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Designation</div>
                                                                    <div class="fw-medium">{{ $item['designation'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">From</div>
                                                                    <div class="fw-medium">{{ $item['from_date'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">To</div>
                                                                    <div class="fw-medium">{{ $item['to_date'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Reason For leaving</div>
                                                                    <div class="fw-medium">
                                                                        {{ $item['reason_for_leaving'] }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted"><span style="font-weight:700;">experience_letter  </span><button type="button"
                                                                            class="btn btn-sm btn-outline-primary ms-2"
                                                                            onclick="window.open('{{ $item['experience_letter'] }}', '_blank')">
                                                                            <i class=" fas fa-eye text-purple  "></i>
                                                                        </button></div>
                                                                    <div class="fw-medium">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    </hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- education detail --}}
                                <div class="d-none data-info" id="educationDetail">

                                    <div class="">
                                        <div class="card-body text-muted text-sm">
                                            <div class="card-body">
                                                @foreach ($data['education'] as $item)
                                                    <div class=" mb-3">
                                                        <div class="card-body">
                                                            <!-- First Row: Key Financial Info -->
                                                            <div class="row g-4 text-sm">
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Degree</div>
                                                                    <div class="fw-medium">
                                                                        {{ $item['degree'] }}</div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Institution Name</div>
                                                                    <div class="fw-medium">{{ $item['institution_name'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Year of Passing</div>
                                                                    <div class="fw-medium">{{ $item['year_of_passing'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted">Obtained Marks</div>
                                                                    <div class="fw-medium">{{ $item['grade_percentage'] }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-3">
                                                                    <div class="text-muted"><spa style="font-weight:700;">certificate  </span> <button type="button"
                                                                            class="btn btn-sm btn-outline-primary ms-2"
                                                                            onclick="window.open('{{ $item['certificate'] }}', '_blank')">
                                                                            <i class=" fas fa-eye text-purple "></i>
                                                                        </button></div>
                                                                    <div class="fw-medium">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    </hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Official Details -->
                                <div class="d-none data-info" id="officialDetail">

                                    <div class="">
                                        <div class="card-body text-muted text-sm">
                                            <div class="card-body">
                                                <div class="row g-4 text-sm">
                                                    @php
                                                        $documents = [
                                                            'Resume/CV' => 'resume_cv',
                                                            'Citizenship' => 'citizenship',
                                                            'Pan Card' => 'pan_card',
                                                            'Employee Contract' => 'employee_contract',
                                                            'Appointment Letter' => 'appointment_letter',
                                                        ];
                                                    @endphp

                                                    @foreach ($documents as $label => $field)
                                                        @php
                                                            $fileUrl = $data['officialDocument'][$field] ?? null;
                                                            $fileName = $fileUrl ? basename($fileUrl) : 'N/A';
                                                        @endphp

                                                        <div class="col-12 col-md-6 col-lg-3">
                                                            <div class="text-muted"><span style="font-weight:700">{{ $label }} </span> <button type="button"
                                                                        class="btn btn-sm btn-outline-primary ms-2"
                                                                        onclick="window.open('{{ $fileUrl }}', '_blank')">
                                                                        <i class=" fas fa-eye text-purple "></i>
                                                                    </button></div>
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                @if ($fileUrl)

                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="card-title h6 fw-semibold mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body amd-employee-detail-info-list">
                            <div class="amd-employee-detail-info-row">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-phone text-muted"></i>
                                    Phone
                                </div>
                                <div class="fw-medium">{{ $data['contactInfo']['mobile_number'] }}</div>
                            </div>
                            <div class="amd-employee-detail-info-row">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-envelope text-muted"></i>
                                    Email
                                </div>
                                <a href="#" class="fw-medium text-primary text-decoration-underline">
                                    {{ $data['contactInfo']['email_address'] }}
                                </a>
                            </div>
                            <div class="amd-employee-detail-info-row">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-user text-muted"></i>
                                    Gender
                                </div>
                                <div class="fw-medium">{{ $data['personalInfo']['gender'] }}</div>
                            </div>
                            <div class="amd-employee-detail-info-row">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-birthday-cake text-muted"></i>
                                    Birthday
                                </div>
                                <div class="fw-medium">{{ $data['personalInfo']['date_of_birth'] }}</div>
                            </div>
                            <div class="amd-employee-detail-info-row align-items-start">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                    Temporary Address
                                </div>
                                <div class="fw-medium text-end">
                                    {{ $data['contactInfo']['temporary_address'] }}
                                </div>
                            </div>
                            <div class="amd-employee-detail-info-row align-items-start">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                    Permenent Address
                                </div>
                                <div class="fw-medium text-end">
                                    {{ $data['contactInfo']['permanent_address'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('.emp-info-switch').on('click', function() {
            var value = $(this).data('value');
            $('.data-info').addClass('d-none').removeClass('d-block');
            $('#' + value).removeClass('d-none').addClass('d-block');
            $('.emp-info-switch').removeClass('active'); //active tabs btn here
            $(this).addClass('active');
        });
    </script>
@endpush
