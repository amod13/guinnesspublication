@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="amd-soft-empl-container-custom">

            @include('employeemanagement::admin.pages.employee.partials._navBar')


            <div class="amd-soft-empl-right-content d-flex flex-column">
                <main class="container my-5">
                    @php
                        $isEditing =
                            isset($data['systemAccessDetail']) &&
                            is_array($data['systemAccessDetail']) &&
                            !empty($data['systemAccessDetail']['id']);
                    @endphp

                    <form class="amd-soft-empl-form-step active" novalidate
                        action="{{ $isEditing
                            ? route('employee.update.system.access', [
                                'employeeId' => $data['employeeId'],
                                'id' => $data['systemAccessDetail']['id'],
                            ])
                            : route('employee.store.system.access', $data['employeeId']) }}"
                        method="POST">
                        @csrf

                        @if ($isEditing)
                            @method('PUT')
                        @endif


                        <ul class="nav nav-tabs" id="amd-soft-empl-step1Tabs" role="tablist">
                            <li class="nav-item active">
                                <button class="nav-link active" id="work-tab" data-bs-toggle="tab"
                                    data-bs-target="#systemAccess" type="button" role="tab">
                                    System Access
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content border p-4">
                            <div class="row g-3">

                                {{-- username --}}
                                <div class="col-md-4 amd-soft-empl-input-with-icon">
                                    <label for="username" class="form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input id="username" class="form-control @error('username') is-invalid @enderror"
                                        name="username" required placeholder="enter user name"
                                        value="{{ $data['systemAccessDetail']['username'] ?? old('username') }}" />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- password --}}
                                <div class="col-md-4 amd-soft-empl-input-with-icon">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="{{ isset($data['systemAccessDetail']) ? 'Leave blank to keep existing password' : 'Enter password' }}"
                                        value="" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Confirm Password --}}
                                <div class="col-md-4 amd-soft-empl-input-with-icon">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        placeholder="{{ isset($data['systemAccessDetail']) ? 'Leave blank to keep existing password' : 'Enter password again' }}"
                                        value="" />
                                    @error('confirm_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 amd-soft-empl-input-with-icon">
                                    {{-- status --}}
                                    <label for="status" class="form-label text-muted">Status</label>
                                    <select id="status" name="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value=""
                                            {{ is_null(old('status')) && empty($data['systemAccessDetail']['status']) ? 'selected' : '' }}>
                                            -- Select Status --</option>
                                        @foreach ($data['status'] as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('status', $data['systemAccessDetail']['status'] ?? '') == $key ? 'selected' : '' }}>
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

                                <div class="col-md-4 amd-soft-empl-input-with-icon">
                                    {{-- status --}}
                                    <label for="role" class="form-label text-muted">Role</label>
                                    <select id="role" name="role_id" class="form-select" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach ($data['roles'] as $item)
                                            <option value="{{ $item->id }}"
                                                {{ isset($data['systemAccessDetail']['role_id']) && $data['systemAccessDetail']['role_id'] == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    @if (!$isEditing)
                                        <button class="amd-btn amd-btn-primary amd-btn-small" type="submit">
                                            <i class="fas fa-paper-plane"></i> Final Submit
                                        </button>
                                    @else
                                        <button type="submit" class="amd-btn amd-btn-primary amd-btn-small">Update</button>

                                        <a href="{{ route('employee.index') }}"
                                            class="amd-btn amd-btn-danger amd-btn-small ms-2">
                                            Final submit
                                        </a>
                                    @endif
                                </div>
                            </div>
                    </form>
                </main>
            </div>

        </div>
    </div>
@endsection
