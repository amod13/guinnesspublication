@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="amd-soft-empl-container-custom">

            {{-- nav Bar --}}
            @include('employeemanagement::admin.pages.employee.partials._navBar')

            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container my-5">
                    @php
                        $isEditing =
                            isset($data['documentDetail']) &&
                            is_array($data['documentDetail']) &&
                            !empty($data['documentDetail']['id']);
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate method="POST" enctype="multipart/form-data"
                        action="{{ $isEditing
                            ? route('employee.update.document', ['employeeId' => $data['employeeId'], 'id' => $data['documentDetail']['id']])
                            : route('employee.store.document', $data['employeeId']) }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif


                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item active">
                                <button class="nav-link active" id="work-tab" data-bs-toggle="tab"
                                    data-bs-target="#officaldocument" type="button" role="tab">
                                    Official Document
                                </button>
                            </li>
                        </ul>


                        {{-- Resume / CV --}}
                        <div class="tab-content border p-4">
                            <div class="tab-pane fade show active" id="work" role="tabpanel"
                                aria-labelledby="work-tab">
                                <div id="education-rows">

                                    <div class="row">
                                        {{-- resume --}}
                                        <div class="col-md-3 mb-4">
                                            <label class="form-label">Resume / CV Upload</label>
                                            <div class="certificate-upload-wrapper">
                                                  <input type="file"
                                                            class="certificate-input form-control @error('resume_cv') is-invalid @enderror"
                                                            name="resume_cv" accept="image/*,application/pdf" />
                                                @if (!empty($data['documentDetail']['resume_cv']))
                                                    <div class="existing-certificate" id="existingResumeBox"
                                                        data-type="resume">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            {{-- remove certificate --}}
                                                            <button type="button" id="removeResumeBtn"
                                                                class="btn-close remove-document-btn" data-type="resume"
                                                                aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['resume_cv']; @endphp

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
                                                @error('resume_cv')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Citizenship --}}
                                        <div class="col-md-3 mb-4">
                                            <label class="form-label">Citizenship Copy Upload</label>
                                            <div class="certificate-upload-wrapper">
                                              <input type="file"
                                                            class="certificate-input form-control @error('citizenship') is-invalid @enderror"
                                                            name="citizenship" accept="image/*,application/pdf" />
                                                @if (!empty($data['documentDetail']['citizenship']))
                                                    <div class="existing-certificate" id="existingCitizenshipBox"
                                                        data-type="citizenship">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            {{-- remove certificate --}}
                                                            <button type="button" id="removeCitizenshipBtn"
                                                                class="btn-close remove-document-btn"
                                                                data-type="citizenship" aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['citizenship']; @endphp

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

                                                @error('citizenship')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- PAN Card --}}
                                        <div class="col-md-3 mb-4">
                                            <label class="form-label">PAN Card Upload</label>
                                            <div class="certificate-upload-wrapper">

                                                {{-- Upload Box --}}
                                                                    <input type="file"
                                                            class="certificate-input form-control @error('pan_card') is-invalid @enderror"
                                                            name="pan_card" accept="image/*,application/pdf" />

                                                {{-- Existing PAN Card Preview --}}
                                                @if (!empty($data['documentDetail']['pan_card']))
                                                    <div class="existing-certificate" id="existingPanCardBox"
                                                        data-type="pan_card">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            <button type="button" id="removePanCardBtn"
                                                                data-type="pan_card" class="btn-close remove-document-btn"
                                                                aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['pan_card']; @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Certificate"
                                                                style="max-width: 100%; height: auto;" />
                                                        @elseif(Str::endsWith($url, '.pdf'))
                                                            <a href="{{ $url }}" target="_blank">View
                                                                Certificate
                                                                (PDF)</a>
                                                        @else
                                                            <span>No valid certificate found.</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                {{-- Error Feedback --}}
                                                @error('pan_card')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Appointment Letter --}}
                                        <div class="col-md-3 mb-4">
                                            <label class="form-label">Appointment Letter Upload</label>
                                            <div class="certificate-upload-wrapper">
                                                   <input type="file"
                                                            class="certificate-input form-control @error('appointment_letter') is-invalid @enderror"
                                                            name="appointment_letter" accept="image/*,application/pdf" />
                                                @if (!empty($data['documentDetail']['appointment_letter']))
                                                    <div class="existing-certificate" id="existingAppointmentLetterBox"
                                                        data-type="appointment_letter">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            {{-- remove certificate --}}
                                                            <button type="button" id="removeAppointmentLetterBtn"
                                                                class="btn-close remove-document-btn"
                                                                data-type="appointment_letter"
                                                                aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['appointment_letter']; @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Certificate"
                                                                style="max-width: 100%; height: auto;" />
                                                        @elseif(Str::endsWith($url, '.pdf'))
                                                            <a href="{{ $url }}" target="_blank">View
                                                                Certificate
                                                                (PDF)</a>
                                                        @else
                                                            <span>No valid certificate found.</span>
                                                        @endif
                                                    </div>
                                                @endif
                                                @error('appointment_letter')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        {{-- Employee Contract --}}
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Employee Contract Upload</label>
                                            <div class="certificate-upload-wrapper">
                                                      <input type="file"
                                                            class="certificate-input form-control @error('employee_contract') is-invalid @enderror"
                                                            name="employee_contract" accept="image/*,application/pdf" />

                                                @if (!empty($data['documentDetail']['employee_contract']))
                                                    <div class="existing-certificate" id="existingEmployeeContractBox">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Certificate:</p>
                                                            {{-- remove certificate --}}
                                                            <button type="button" id=""
                                                                class="btn-close remove-document-btn"
                                                                id="removeEmployeeContractBtn"
                                                                data-type="employee_contract"
                                                                aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['employee_contract']; @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Certificate"
                                                                style="max-width: 100%; height: auto;" />
                                                        @elseif(Str::endsWith($url, '.pdf'))
                                                            <a href="{{ $url }}" target="_blank">View
                                                                Certificate
                                                                (PDF)</a>
                                                        @else
                                                            <span>No valid certificate found.</span>
                                                        @endif
                                                    </div>
                                                @endif
                                                @error('employee_contract')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Photo --}}
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Photo Upload</label>
                                            <div class="certificate-upload-wrapper">
                                                      <input type="file"
                                                            class="certificate-input form-control @error('photo') is-invalid @enderror"
                                                            name="photo" accept="image/*" />

                                                @if (!empty($data['documentDetail']['photo']))
                                                    <div class="existing-certificate" id="existingPhotoBox"
                                                        data-type="photo">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                            <p class="mb-0">Existing Photo:</p>
                                                            <button type="button" id="removePhotoBtn"
                                                                class="btn-close remove-document-btn" data-type="photo"
                                                                aria-label="Remove"></button>
                                                        </div>

                                                        @php $url = $data['documentDetail']['photo']; @endphp

                                                        @if (Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif']))
                                                            <img src="{{ $url }}" alt="Photo"
                                                                style="max-width: 100%; height: auto;" />
                                                        @else
                                                            <span>No valid photo found.</span>
                                                        @endif
                                                    </div>
                                                @endif

                                                @error('photo')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        @if (!$isEditing)
                            <div class="d-flex justify-content-start">
                                <button class="amd-btn amd-btn-primary amd-btn-small" type="submit">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                            </div>
                        @else
                            <button type="submit" class="amd-btn amd-btn-primary amd-btn-small">Update</button>

                            {{-- <a href="#"
                                class="amd-btn amd-btn-danger amd-btn-small ms-2">
                                Next Step
                            </a> --}}
                        @endif
                    </form>
                </main>
            </div>

        </div>
    </div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const removeButtons = document.querySelectorAll(".remove-document-btn");

        removeButtons.forEach((btn) => {
            btn.addEventListener("click", function() {
                const type = btn.getAttribute("data-type");
                const existingBox = document.querySelector(
                    `[id='existing${capitalize(type)}Box']`);
                const uploadBox = document.querySelector(`[id='${capitalize(type)}UploadBox']`);

                if (existingBox) existingBox.classList.add("d-none");
                if (uploadBox) uploadBox.classList.remove("d-none");
            });
        });

        function capitalize(str) {
            return str.split('_')
                .map(s => s.charAt(0).toUpperCase() + s.slice(1))
                .join('');
        }
    });
</script>
