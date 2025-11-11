@extends('admin.main.app')
@section('content')

    <div class="card shadow-sm border-0">
        {{-- Header Section --}}
        <div class="card-header bg-info text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-images me-2"></i>{{ $category->title ?? 'Gallery' }} Items
                    </h5>
                    <small class="opacity-75">Manage individual gallery items</small>
                </div>
                <div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-light btn-sm me-2">
                        <i class="fas fa-arrow-left me-1"></i>Back to Categories
                    </a>
                    <a href="{{ route('gallery.create', ['category' => $category->id ?? '']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus me-1"></i>Add New Item
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Bulk Actions -->
            <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('gallery.bulk.delete') }}">
                {{-- Filter --}}
                <x-table.filter :action="route('gallery.index', ['category' => $category->id ?? ''])" :placeholder="'Search gallery items'" />

                <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary checkedAll">
                            </th>
                            <th>S.N.</th>
                            <th>Preview</th>
                            <th>Caption</th>
                            <th>Type</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['records'] as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="row-select form-check-input amd-colored-check primary" value="{{ $item['id'] }}">
                                </td>
                                <td class="serial-number">{{ ($data['records']->currentPage() - 1) * $data['records']->perPage() + $loop->iteration }}</td>
                                <td>
                                    @if($item['file_type'] === 'image')
                                        <img src="{{ asset('storage/gallery/' . $item['image']) }}"
                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-success text-white d-flex align-items-center justify-content-center rounded"
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-video fa-lg"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item['caption'] ?: 'No caption' }}</strong>
                                        @if($item['file_type'] === 'video')
                                            <br><small class="text-muted">{{ Str::limit($item['video_url'], 40) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="amd-badge {{ $item['file_type'] === 'image' ? 'amd-badge-outline-primary' : 'amd-badge-outline-info' }}">
                                        {{ ucfirst($item['file_type']) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($item['created_at'])->format('M d, Y') }}</small>
                                </td>
                                <td name="bstable-actions">
                                    <div class="btn-group">
                                        {{-- Edit Button --}}
                                        <x-table.edit-button :id="$item['id']" :route="'gallery.edit'" />
                                        {{-- Delete Button --}}
                                        <x-table.delete-button :id="$item['id']" :route="'gallery.destroy'" />
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
