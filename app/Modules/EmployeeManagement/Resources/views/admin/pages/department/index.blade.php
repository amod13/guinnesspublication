@extends('admin.main.app')

@section('content')
    <div class="row p-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Header with title and Add button -->
                    <div class="amd-soft-table-header p-3 d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0 text-black">Departments</h3>
                        <a href="{{ route('department.create') }}" class="amd-btn amd-btn-primary amd-btn-small">
                            <i class="fa-solid fa-plus"></i> Add new column
                        </a>
                    </div>

                    <!-- Sub-header with rows selector, date range button, and search -->
                    <form method="GET" action="{{ route('department.index') }}" class="row mb-3">
                        <div class="amd-soft-subheader d-flex justify-content-between">
                            <div class="row-selector">
                                <label for="rowCount">Show rows:</label>
                                <select name="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                                    @foreach ([2, 3, 5, 10, 25, 50, 100] as $size)
                                        <option value="{{ $size }}"
                                            {{ request('perPage', 2) == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="amd-soft-header-right  ">
                                <div class=" p-3">
                                    <div class="search-wrapper">
                                        <input type="search" name="search" id="tableSearch" value="{{ request('search') }}"
                                            placeholder="Search..." aria-label="Search table" />
                                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="amd-soft-table-wrapper" tabindex="0" aria-label="Data table container">
                        <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data['records']) && $data['records']->count())
                                    @foreach ($data['records'] as $index)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $index->name }}</td>
                                            <td>
                                                @if ($index->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('department.edit', $index->id) }}"
                                                    class="btn btn-sm me-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('department.delete', $index->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this department?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No departments found.</td>
                                    </tr>
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
    </div>
@endsection
