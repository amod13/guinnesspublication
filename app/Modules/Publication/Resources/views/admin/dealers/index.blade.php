@extends('admin.main.app')
@section('content')

<form action="{{ route('dealers.index') }}" method="GET" class="position-relative">
    {{-- Close / Cross Icon --}}
    <button type="button" class="toggle-filter-btn-close position-absolute top-0 end-0 m-3 d-none amd-btn amd-btn-danger amd-btn-square-sm" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>
    {{-- Search Filters --}}
    <div id="filterCard" class="amd-fillter-card p-4 border rounded-4 mb-4 d-none">
        <div class="row g-3 align-items-end">

            <div class="col-md-6">
                <label for="keywords" class="form-label text-muted">Search By Keywords</label>
                <input type="text" id="keywords" name="keywords" class="form-control"
                    value="{{ old('keywords', request('keywords')) }}">
            </div>

            <div class="col-md-6">
                <label for="statusSelect" class="form-label text-muted">Dealer Status</label>
                <select id="statusSelect" name="status" class="form-select">
                    <option value="">All</option>
                    <option value="active" {{ old('status', request('status')) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', request('status')) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-12 d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dealers.index') }}" class="btn btn-outline-secondary amd-btn-small rounded-pill px-4">Reset</a>
                    <button type="submit" class="amd-btn amd-btn-primary amd-btn-small rounded-pill px-4">Apply</button>
                </div>
            </div>
        </div>
    </div>
    </form>


    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Dealers List'" :createRoute="route('dealers.create')" :column="true" :columnLabel="'Column Manage'" :tableId="'DealerListTable'" :createLabel="'Add New'" :isSearch="true" :isDashboard="false" />

        <div class="card-body">
            <!-- Bulk Actions will be dynamically created by JS -->

            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('dealers.bulk-delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('dealers.index')" :placeholder="'Search Dealers'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description" id="DealerListTable"
                    data-column-manage="true">
                    <thead class="sortable-headers">
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary">
                            </th>
                            <th>S.N.</th>
                            <th data-sort="name">Name</th>
                            <th data-sort="email">Email</th>
                            <th data-sort="phone_number">Phone Number</th>
                            <th data-sort="address">Address</th>
                            <th data-sort="status">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('dealers.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary" value="{{ $item['id'] }}">
                                </td>
                                <td>{{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['phone_number'] }}</td>
                                <td>{{ $item['address'] }}</td>
                                <td>
                                    <x-table.status-badge :status="$item['status']" />
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group pull-right">
                                        <x-table.edit-button :id="$item['id']" :route="'dealers.edit'" />
                                        <x-table.delete-button :id="$item['id']" :route="'dealers.destroy'" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <x-table.pagination :records="$data['records']" />
            </div>
        </div>
    </div>

    <!-- Column Manager Modal -->
    <x-table.manage-columns-modal />
@endsection
