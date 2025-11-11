@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="amd-soft-empl-container-custom">

            @include('employeemanagement::admin.pages.employee.partials._navBar')


            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container my-5">
                    @php
                        $isEditing = isset($data['educationDetail']) && !empty($data['educationDetail']);
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate method="POST"
                        action="{{ $isEditing
                            ? route('employee.update.education', [
                                'employeeId' => $data['employeeId'],
                                'eduId' => $data['educationDetail']['id'],
                            ])
                            : route('employee.store.education', $data['employeeId']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif


                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item active">
                                <button class="nav-link active" id="education-tab" data-bs-toggle="tab"
                                    data-bs-target="#education" type="button" role="tab">
                                    Education
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4">
                            {{-- education --}}
                            <div class="tab-pane fade show active" id="education" role="tabpanel"
                                aria-labelledby="education-tab">
                                <div id="education-rows" class="container">
                                    <div class="row g-3">
                                        <!-- First Row (3 columns) -->
                                        <div class="col-md-4">
                                            <label class="form-label">Degree</label>
                                            <input type="text" class="form-control @error('degree') is-invalid @enderror"
                                                name="degree" placeholder="e.g., BCA"
                                                value="{{ old('degree') ?? ($data['educationDetail']['degree'] ?? '') }}"
                                                required />
                                            @error('degree')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Institution Name</label>
                                            <input type="text"
                                                class="form-control @error('institution_name') is-invalid @enderror"
                                                name="institution_name" placeholder="e.g., XYZ College"
                                                value="{{ old('institution_name', $data['educationDetail']['institution_name'] ?? '') }}"
                                                required />
                                            @error('institution_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Year of Passing</label>
                                            <input type="text"
                                                class="form-control @error('year_of_passing') is-invalid @enderror"
                                                name="year_of_passing" placeholder="e.g., 2024"
                                                value="{{ old('year_of_passing', $data['educationDetail']['year_of_passing'] ?? '') }}"
                                                required />
                                            @error('year_of_passing')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Second Row (2 columns) -->
                                        <div class="col-md-6">
                                            <label class="form-label">Grade / Percentage</label>
                                            <input type="text"
                                                class="form-control @error('grade_percentage') is-invalid @enderror"
                                                name="grade_percentage" placeholder="e.g., 75% / A"
                                                value="{{ old('grade_percentage', $data['educationDetail']['grade_percentage'] ?? '') }}"
                                                required />
                                            @error('grade_percentage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Certificate Upload</label>
                                            <div class="certificate-upload-wrapper">
                                                {{-- Upload Box --}}
                                                <input type="file"
                                                    class="form-control @error('certificate') is-invalid @enderror"
                                                    name="certificate" accept="image/*,application/pdf" />

                                                {{-- Existing Certificate --}}
                                                @if (!empty($data['educationDetail']['certificate']))
                                                    <div class="existing-certificate" id="existingCertificateBox">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            <button type="button" id="removeCertificateBtn"
                                                                class="btn-close" aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['educationDetail']['certificate']; @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Certificate"
                                                                style="max-width: 100%; height: auto;" />
                                                        @elseif(Str::endsWith($url, '.pdf'))
                                                            <a href="{{ $url }}" target="_blank">View Certificate
                                                                (PDF)</a>
                                                        @else
                                                            <span>No valid certificate found.</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            @error('certificate')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <!-- Buttons Layout -->
                                <div class="d-flex justify-content-between align-items-center p-2 mt-4">

                                    @php
                                        $isEditing =
                                            isset($data['educationDetail']) && !empty($data['educationDetail']);
                                        $hasEduList = isset($data['eduList']) && count($data['eduList']) > 0;
                                    @endphp

                                    {{-- Case 1: No data yet → Submit --}}
                                    @if (!$hasEduList)
                                        <button class="amd-btn amd-btn-primary amd-btn-small ms-auto" type="submit">
                                            <i class="fas fa-paper-plane"></i> Submit
                                        </button>

                                        {{-- Case 2: Editing a record → Show Update and Reset --}}
                                    @elseif ($isEditing)
                                        <button type="submit"
                                            class="amd-btn amd-btn-primary amd-btn-small ms-auto">Update</button>

                                        <a href="{{ route('employee.create.education', ['employeeId' => $data['employeeId']]) }}"
                                            class="amd-btn amd-btn-danger amd-btn-small ms-2">
                                            Reset
                                        </a>

                                        {{-- Case 3: Has data, not editing → Show Add --}}
                                    @else
                                        <button class="amd-btn amd-btn-primary amd-btn-small ms-auto">Add</button>
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
                                        <h3 class="card-title mb-0 text-black">Education Details</h3>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="amd-soft-table-wrapper" tabindex="0" aria-label="Data table container">
                                    <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>degree</th>
                                                <th>institution name</th>
                                                <th>year of passing</th>
                                                <th>grade percentage</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['eduList']))
                                                @foreach ($data['eduList'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item['degree'] }}</td>
                                                        <td>{{ $item['institution_name'] }}</td>
                                                        <td>{{ $item['year_of_passing'] }}</td>
                                                        <td>{{ $item['grade_percentage'] }}</td>
                                                        <td class="d-flex">
                                                            {{-- Edit Button --}}
                                                            <a href="{{ route('employee.edit.education', ['employeeId' => $data['employeeId'], 'eduId' => $item['id']]) }}"
                                                                class="btn btn-sm  me-2" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            {{-- Delete Form --}}
                                                            <form
                                                                action="{{ route('employee.delete.education', ['employeeId' => $data['employeeId'], 'eduId' => $item['id']]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this education record?');"
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
                                                <td>
                                                    no education detail filled
                                                </td>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!-- Pagination -->
                                    <div class="mt-3">
                                        @include('employeemanagement::includes.pagination')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>

        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const removeBtn = document.getElementById('removeCertificateBtn');
        const existingBox = document.getElementById('existingCertificateBox');
        const uploadBox = document.getElementById('certificateUploadBox');
        const removeFlag = document.getElementById('removeCertificateFlag');

        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                existingBox.classList.add('d-none');
                uploadBox.classList.remove('d-none');
            });
        }
    });
</script>
