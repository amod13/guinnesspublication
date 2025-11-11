@extends('admin.main.app')
@section('content')
    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Book List'" :createRoute="route('books.create')" :createLabel="'Add New'" />

        <div class="card-body">
            <!-- Bulk Actions will be dynamically created by JS -->

            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('books.bulk-delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('books.index')" :placeholder="'Search book...'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                            <input type="checkbox" id="select-all"
                                    class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('books.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary"
                                        value="{{ $item['id'] }}">
                                </td>
                                <td class="serial-number">
                                    {{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $item['title'] }}</td>
                                <td>
                                    <x-table.status-badge :status="$item['status']" />
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group pull-right">
                                        <x-table.edit-button :id="$item['id']" :route="'books.edit'" />
                                        <x-table.delete-button :id="$item['id']" :route="'books.destroy'" />
                                        <x-table.action-button :id="$item['id']" :route="'books.show'" :icon="'fas fa-eye'" :title="'View'" />
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
