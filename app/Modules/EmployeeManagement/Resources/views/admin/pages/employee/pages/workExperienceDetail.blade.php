@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="amd-soft-empl-container-custom">

            @include('employeemanagement::admin.pages.employee.partials._navBar')


            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container my-5">
                    @php
                        $isEditing = isset($data['workDetail']) && !empty($data['workDetail']);
                        $hasWorkList = isset($data['workList']) && count($data['workList']) > 0;
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate method="POST"
                        action="{{ $isEditing
                            ? route('employee.update.work', ['employeeId' => $data['employeeId'], 'id' => $data['workDetail']['id']])
                            : route('employee.store.work', $data['employeeId']) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif


                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item active">
                                <button class="nav-link active" id="work-tab" data-bs-toggle="tab" data-bs-target="#work"
                                    type="button" role="tab">
                                    Work Experience
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4">
                            <div class="tab-pane fade show active" id="work" role="tabpanel"
                                aria-labelledby="work-tab">
                                <div id="education-rows">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Organization Name</label>
                                            <input type="text"
                                                class="form-control @error('organization_name') is-invalid @enderror"
                                                name="organization_name"
                                                value="{{ old('organization_name', $data['workDetail']['organization_name'] ?? '') }}"
                                                placeholder="e.g., ABC Pvt Ltd" required />
                                            @error('organization_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Designation</label>
                                            <input type="text"
                                                class="form-control @error('designation') is-invalid @enderror"
                                                name="designation"
                                                value="{{ old('designation', $data['workDetail']['designation'] ?? '') }}"
                                                placeholder="e.g., Software Engineer" required />
                                            @error('designation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">From Date</label>
                                            <input type="date"
                                                class="form-control @error('from_date') is-invalid @enderror"
                                                name="from_date"
                                                value="{{ old('from_date', $data['workDetail']['from_date'] ?? '') }}" />
                                            @error('from_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">To Date</label>
                                            <input type="date"
                                                class="form-control @error('to_date') is-invalid @enderror" name="to_date"
                                                value="{{ old('to_date', $data['workDetail']['from_date'] ?? '') }}"
                                                required />
                                            @error('to_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row g-3 mt-1">
                                        <div class="col-md-6">
                                            <label class="form-label">Reason for Leaving</label>
                                            <input type="text"
                                                class="form-control @error('reason_for_leaving') is-invalid @enderror"
                                                name="reason_for_leaving"
                                                value="{{ old('reason_for_leaving', $data['workDetail']['reason_for_leaving'] ?? '') }}"
                                                placeholder="e.g., Better Opportunity" required />
                                            @error('reason_for_leaving')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">work Experience</label>
                                            <div class="certificate-upload-wrapper">
                                                     <input type="file"
                                                            class="certificate-input form-control @error('experience_letter') is-invalid @enderror"
                                                            name="experience_letter" accept="image/*,application/pdf" />
                                                {{-- edit mode --}}
                                                @if (!empty($data['workDetail']['experience_letter']))
                                                    <div class="existing-certificate" id="existingExperienceBox">

                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing work Experience:</p>
                                                            {{-- remove certificate --}}
                                                            <button type="button" id="removeWorkBtn" class="btn-close"
                                                                aria-label="Remove"></button>
                                                        </div>
                                                        @php
                                                            $url = $data['workDetail']['experience_letter'];
                                                        @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Certificate"
                                                                style="max-width: 100%; height: auto;" />
                                                        @elseif(Str::endsWith($url, '.pdf'))
                                                            <a href="{{ $url }}" target="_blank">work experience
                                                                letter
                                                                (PDF)</a>
                                                        @else
                                                            <span>No work experience letter</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>

                                            @error('experience_letter')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center p-2 mt-4">


                                @if (!$hasWorkList)
                                    <button class="amd-btn amd-btn-primary amd-btn-small ms-auto" type="submit">
                                        <i class="fas fa-paper-plane"></i> Submit
                                    </button>
                                @elseif($isEditing)
                                    <button type="submit"
                                        class="amd-btn amd-btn-primary amd-btn-small ms-auto">Update</button>

                                    <a href="{{ route('employee.create.work', ['employeeId' => $data['employeeId']])}}"
                                        class="amd-btn amd-btn-danger amd-btn-small ms-2">
                                        Reset
                                    </a>
                                @else
                                    <button class="amd-btn amd-btn-primary amd-btn-small ms-auto">Add</button>
                                @endif
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
                                        <h3 class="card-title mb-0 text-black">work Details</h3>
                                    </div>
                                </div>

                                <!-- Table -->
                                <div class="amd-soft-table-wrapper" tabindex="0" aria-label="Data table container">
                                    <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Organization Name</th>
                                                <th>Designation</th>
                                                <th>From date</th>
                                                <th>To date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['workList']))
                                                @foreach ($data['workList'] as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item['organization_name'] }}</td>
                                                        <td>{{ $item['designation'] }}</td>
                                                        <td>{{ $item['from_date'] }}</td>
                                                        <td>{{ $item['to_date'] }}</td>
                                                        <td class="d-flex">
                                                            {{-- Edit Button --}}
                                                            <a href="{{ route('employee.edit.work', ['employeeId' => $data['employeeId'],
                                                                'id' => $item['id']])  }}"
                                                                class="btn btn-sm  me-2" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            {{-- Delete Form --}}
                                                            <form
                                                                action="{{ route('employee.delete.work', ['employeeId' => $data['employeeId'],
                                                                'id' => $item['id']]) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Are you sure you want to delete this record?');"
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
                                                    No work experience data filled
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
    document.addEventListener("DOMContentLoaded", function() {
        const removeBtn = document.getElementById("removeWorkBtn");
        const existingBox = document.getElementById("existingExperienceBox");
        const uploadBox = document.querySelector(".certificate-upload-box");

        if (removeBtn && existingBox && uploadBox) {
            removeBtn.addEventListener("click", function() {
                // Hide the existing certificate preview box
                existingBox.classList.add("d-none");

                // Show the file upload input box
                uploadBox.classList.remove("d-none");
            });
        }
    });
</script>
