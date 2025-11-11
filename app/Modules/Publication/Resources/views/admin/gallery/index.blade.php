@extends('admin.main.app')
@section('content')

    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Gallery List'" :createRoute="route('gallery.create')" :createLabel="'Add New'" />

        <div class="card-body">
            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('gallery.bulk.delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('gallery.index')" :placeholder="'Search galleries'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Category</th>
                            <th>Total Items</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['records'] as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary" value="{{ $item->category_id }}">
                                </td>
                                <td class="serial-number">{{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <h6 class="mb-0">{{ $item->category->title ?? 'No Category' }}</h6>
                                            <small class="text-muted">{{ $item->total_items }} items</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="amd-badge amd-badge-outline-primary">{{ $item->total_items }} Items</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('gallery.index', ['category' => $item->category_id]) }}" class="amd-btn amd-btn-primary amd-btn-outline amd-btn-sm">
                                            <i class="fas fa-list me-1"></i>Manage Items
                                        </a>
                                        <a href="{{ route('gallery.create', ['category' => $item->category_id]) }}" class="amd-btn amd-btn-primary amd-btn-square amd-btn-sm">
                                            <i class="fas fa-plus me-1"></i>Add New
                                        </a>
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
@endsection
