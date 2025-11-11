@extends('admin.main.app')


@section('content')
    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h5 class="card-title mb-3">Edit designation</h5>

        <form action="{{ route('designation.update', $data['record']->id) }}" method="POST" id="designationForm">
            @csrf
            @method('PUT') <!-- for PUT update -->

            <div class="mb-3">
                <label for="name" class="form-label">designation Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $data['record']->name) }}" placeholder="e.g., IT designation">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="1" {{ old('status', $data['record']->status) == 1 ? 'selected' : '' }}>Active
                    </option>
                    <option value="0" {{ old('status', $data['record']->status) == 0 ? 'selected' : '' }}>Inactive
                    </option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end ">
                <button class="btn btn-primary g-2">Update</button>
            </div>
        </form>
    </div>
@endsection
