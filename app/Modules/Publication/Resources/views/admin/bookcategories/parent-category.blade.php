@extends('admin.main.app')
@section('content')
    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-ui.page-header :backRoute="route('bookcategories.index')" :title="'Categories List'" />

        <div class="card-body">
            <!-- Bulk Actions will be dynamically created by JS -->

            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('bookcategories.bulk-delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('bookcategories.index')" :placeholder="'Search Parent Categories..'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox"
                                    id="select-all"class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Total children</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('bookcategories.order') }}">
                        @foreach ($data['records'] as $item)
                            <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary"
                                        value="{{ $item['id'] }}">
                                </td>
                                <td class="serial-number">
                                    {{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td><span>{{ $item['children_count'] }}</span></td>
                                <td>
                                    <x-table.status-badge :status="$item['status']" />
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group pull-right">
                                        {{-- Edit Button --}}
                                        <x-table.edit-button :id="$item['id']" :route="'bookcategories.edit'" />
                                        <x-table.delete-button :id="$item['id']" :route="'bookcategories.destroy'" />
                                        @if ($item['children_count'] > 0)
                                            <x-table.action-button :id="$item['id']" :route="'bookcategories.parent'" icon="fa fa-list" />
                                        @endif
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
