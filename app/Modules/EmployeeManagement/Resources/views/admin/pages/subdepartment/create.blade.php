@extends('admin.main.app')

@section('content')
    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h5 class="card-title mb-3">Add Sub Department</h5>
        <form action="{{ route('subdepartment.store') }}" method="POST" id="subDepartmentForm">
            @csrf

            {{-- Department Dropdown --}}
            <div class="mb-3">
                <label for="dept_id" class="form-label">Select Department</label>
                <select name="dept_id" id="dept_id" class="form-select @error('dept_id') is-invalid @enderror">
                    <option value="">-- Select Department --</option>
                    @if (!empty($data['dept']))
                        @foreach ($data['dept'] as $dept)
                            <option value="{{ $dept['id'] }}" {{ old('dept_id') == $dept['id'] ? 'selected' : '' }}>
                                {{ $dept['name'] }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('dept_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- SubDepartment Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">SubDepartment Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="e.g., Web Development">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
@endsection
