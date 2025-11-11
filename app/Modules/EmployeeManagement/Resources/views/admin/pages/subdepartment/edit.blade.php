@extends('admin.main.app')

@section('content')
    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h5 class="card-title mb-3">Edit Sub Department</h5>

        <form action="{{ route('subdepartment.update', $data['record']->id) }}" method="POST" id="subDepartmentEditForm">
            @csrf
            @method('PUT')

            {{-- Sub Department Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Sub Department Name</label>
                <input type="text" name="name" id="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $data['record']->name) }}"
                    placeholder="e.g., Software Team">

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Department Dropdown --}}
            <div class="mb-3">
                <label for="dept_id" class="form-label">Department</label>
                <select name="dept_id" id="dept_id" class="form-select @error('dept_id') is-invalid @enderror">
                    <option value="">-- Select Department --</option>
                    @foreach ($data['dept'] as $dept)
                        <option value="{{ $dept['id'] }}" {{ $dept['id'] == $data['record']->dept_id ? 'selected' : '' }}>
                            {{ $dept['name'] }}
                        </option>
                    @endforeach
                </select>

                @error('dept_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ $data['record']->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $data['record']->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>

                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
