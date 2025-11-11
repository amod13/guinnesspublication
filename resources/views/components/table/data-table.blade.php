@props([
    'title' => null,
    'createRoute' => null,
    'createLabel' => 'Add New',
    'bulkDeleteUrl' => null,
    'filterAction' => null,
    'filterPlaceholder' => 'Search...',
    'records' => [],
    'columns' => [],
    'sortUrl' => null,
    'editRoute' => null,
    'deleteRoute' => null,
    'viewRoute' => null,
    'sortable' => false, // default true
])

<div class="card shadow-sm border-0">
    {{-- Header --}}
    <x-table.top-header :title="$title" :createRoute="$createRoute" :createLabel="$createLabel" />

    <div class="card-body">
        <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ $bulkDeleteUrl }}">
            {{-- Filter --}}
            <x-table.filter :action="$filterAction" :placeholder="$filterPlaceholder" />

            <table class="amd-soft-table" role="grid">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="select-all"
                                class="form-check-input amd-colored-check primary checkedAll">
                        </th>
                        @foreach ($columns as $col)
                            <th>{{ $col['label'] ?? ($col['title'] ?? '') }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody @class(['sortable-table' => $sortable])
                    @if ($sortable && $sortUrl) data-sort-url="{{ $sortUrl }}" @endif>
                    @foreach ($records as $item)
                        <tr data-id="{{ $item['id'] }}" data-display-order="{{ $item['display_order'] ?? '' }}">
                            <td>
                                <input type="checkbox" class="row-select form-check-input amd-colored-check primary"
                                    value="{{ $item['id'] }}">
                            </td>
                            @foreach ($columns as $col)
                                <td>
                                    @php
                                        $field = $col['field'] ?? ($col['data'] ?? ($col['name'] ?? ''));
                                    @endphp
                                    @if (($col['type'] ?? 'text') === 'status')
                                        <x-table.status-badge :status="$item[$field]" />
                                    @elseif(($col['type'] ?? 'text') === 'boolean')
                                        <x-table.custom-badge :status="$item[$field]" :type="'boolean'" />
                                    @else
                                        {{ $item[$field] ?? '' }}
                                    @endif
                                </td>
                            @endforeach
                            <td name="bstable-actions">
                                <div class="btn-group pull-right">
                                    <x-table.edit-button :id="$item['id']" :route="$editRoute" />
                                    <x-table.delete-button :id="$item['id']" :route="$deleteRoute" />

                                       @if(!empty($viewRoute))
                                    <x-table.action-button :id="$item['id']" :route="$viewRoute"  icon="fa fa-eye" />
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <x-table.pagination :records="$records" />
        </div>
    </div>
</div>
