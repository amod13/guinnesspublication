@extends('admin.main.app')
@section('content')
    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <x-table.top-header :title="'Page List'" :createRoute="route('page.create')" :createLabel="'Add New'" />

        <div class="card-body">
            <!-- Table -->
            <div class="amd-soft-table-wrapper bulk-enabled"
                data-bulk-delete-url="{{ route('page.bulk.delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('page.index')" :placeholder="'Search pages'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all"
                                    class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="sortable-table" data-sort-url="{{ route('page.order') }}">
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
                                <td>{{ $item['slug'] }}</td>
                                <td>
                                    <x-table.status-badge :status="$item['status']" />
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group pull-right">
                                        <x-table.edit-button :id="$item['id']" :route="'page.edit'" />
                                        <x-table.delete-button :id="$item['id']" :route="'page.destroy'" />
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