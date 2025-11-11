@if ($mediaItems->count() > 0)
    <div class="media-grid">
        @foreach ($mediaItems as $item)
            <div class="media-item" data-id="{{ $item->id }}">
                <input type="checkbox" class="media-checkbox" data-id="{{ $item->id }}">
                <div class="media-thumbnail">
                    @if ($item->isImage())
                        <img src="{{ $item->url }}" alt="{{ $item->alt_text }}">
                    @elseif($item->isVideo())
                        <i class="fas fa-video file-icon"></i>
                    @elseif($item->isAudio())
                        <i class="fas fa-music file-icon"></i>
                    @else
                        <i class="fas fa-file file-icon"></i>
                    @endif
                </div>
                <div class="media-info">
                    <h4 class="media-title">{{ $item->title }}</h4>
                    <div class="media-meta">
                        {{ $item->file_size_formatted }} • {{ ucfirst($item->file_type) }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if ($mediaItems->hasPages())
        <div style="margin-top: 20px;">
            <x-table.pagination :records="$mediaItems" />
        </div>
    @endif
@else
    <div class="empty-state">
        <i class="fas fa-images"></i>
        <h3>No media files found</h3>
        <p>Upload your first media file to get started.</p>
    </div>
@endif
