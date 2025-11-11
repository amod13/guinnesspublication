@extends('admin.main.app')

@section('content')
    <div class="row ">
        <div class="amd-soft-empl-container-custom">

            @include('employeemanagement::admin.pages.employee.partials._navBar')

            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container  ">
                    @php
                        $isEdit = isset($data['employeeDetail']);
                        // dd($data['employeeId']);
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate
                        action="{{ $isEdit ? route('employee.edit.basic', $data['employeeId']) : route('employee.store.basic') }}"
                        method="POST">
                        @csrf

                        @if ($isEdit)
                            @method('PUT')
                        @endif

                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link step1 active" id="personal-tab" data-bs-toggle="tab"
                                    data-bs-target="#personal" type="button" role="tab">
                                    A. Personal Info
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link step2 " id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact" type="button" role="tab">
                                    B. Contact Info
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link step3 " id="employment-tab" data-bs-toggle="tab"
                                    data-bs-target="#employment" type="button" role="tab">
                                    C. Employment
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4">

                            @include('employeemanagement::admin.pages.employee.partials.BasicInfo.personalInfo')

                            @include('employeemanagement::admin.pages.employee.partials.BasicInfo.contactInfo')

                            @include('employeemanagement::admin.pages.employee.partials.BasicInfo.empDetail')

                        </div>
                    </form>

                </main>
            </div>

        </div>
    </div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Handle "Next" button click to switch tabs
        document.querySelectorAll('button[data-next]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const nextTabSelector = btn.getAttribute('data-next');
                const nextTab = document.querySelector(nextTabSelector);
                if (nextTab) {
                    // Bootstrap 5: Use Tab API to show the tab
                    const tab = new bootstrap.Tab(nextTab);
                    tab.show();
                }
            });
        });

        // Existing code: Show tab with invalid field
        const invalidField = document.querySelector('.is-invalid');
        if (invalidField) {
            const tabPane = invalidField.closest('.tab-pane');
            if (tabPane && tabPane.id) {
                let tabMap = {
                    personal: 'step1',
                    contact: 'step2',
                    employment: 'step3'
                };
                let stepClass = tabMap[tabPane.id];
                if (stepClass) {
                    const tabTrigger = document.querySelector('.' + stepClass);
                    if (tabTrigger) {
                        tabTrigger.click();
                    }
                }
            }
        }

        // employee not active
        const statusSelect = document.getElementById('employee_status');
        const leavingWrapper = document.getElementById('date_of_leaving_wrapper');

        function toggleLeavingDate() {
            // Change '0' to whatever key represents 'inactive'
            if (statusSelect.value === '0') {
                leavingWrapper.style.display = 'block';
                leavingWrapper.querySelector('input').required = true;
            } else {
                leavingWrapper.style.display = 'none';
                leavingWrapper.querySelector('input').required = false;
            }
        }

        statusSelect.addEventListener('change', toggleLeavingDate);

        // Run on page load in case status is already 'inactive'
        toggleLeavingDate();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deptSelect = document.getElementById('department_id');
        const subDeptSelect = document.getElementById('sub_department_id');
        const oldSubDeptId = document.getElementById('old_sub_department_id').value;

        deptSelect.addEventListener('change', function() {
            // debugger;
            let deptId = this.value;

            // reset dropdown
            subDeptSelect.innerHTML = '<option value="">Select sub department</option>';
            if (!deptId) return;

            fetch("{{ route('subdepartment.getIdNameJson') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        deptId: deptId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.text = 'No sub department found';
                        option.disabled = true; // optional
                        subDeptSelect.appendChild(option);
                        return;
                    }

                    data.forEach(subDept => {
                        const option = document.createElement('option');
                        option.value = subDept.id;
                        option.text = subDept.name;

                        if (oldSubDeptId && oldSubDeptId == subDept.id) {
                            option.selected = true;
                        }

                        subDeptSelect.appendChild(option);
                    });
                })
                .catch(err => console.error('Error fetching sub departments:', err));
        });

        if (deptSelect.value) {
            deptSelect.dispatchEvent(new Event('change'));
        }
    });
</script>


{{-- <script>
    $(document).ready(function() {
        // get deptId when changed.
        $("#department_id").on('change', function(){
            var deptId = this.value; // get the value of clicked thing

            // url
            $.post("subdepartment.getIdNameJson", {
                deptId: deptId,

            })
        })
    })
</script> --}}
