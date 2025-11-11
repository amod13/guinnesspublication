@extends('admin.main.app')


@section('content')
    <div class="card shadow-sm rounded-4 p-4 mb-4">
        <h5 class="card-title mb-3">Add Designation</h5>
        <form action="{{ route('designation.store') }}" method="POST" id="designationForm">
            @csrf
            {{-- Name Field --}}
            <div class="mb-3">
                <label for="name" class="form-label">Designation Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="e.g., mid software developer ">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Status Field --}}
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

            <div class="d-flex justify-content-end ">
                <button class="btn btn-primary g-2">Submit</button>
            </div>

        </form>
    </div>
@endsection
