@if ($mediaItems->count() > 0)
    <div class="media-list">
        @foreach ($mediaItems as $item)
            <div class="media-list-item" data-id="{{ $item->id }}">
                <input type="checkbox" class="media-checkbox" data-id="{{ $item->id }}" style="margin-right: 10px;">

                <div class="media-list-thumbnail">
                    @if ($item->isImage())
                        <img src="{{ $item->url }}" alt="{{ $item->alt_text }}">
                    @elseif($item->isVideo())
                        <i class="fas fa-video" style="font-size: 24px; color: #666;"></i>
                    @elseif($item->isAudio())
                        <i class="fas fa-music" style="font-size: 24px; color: #666;"></i>
                    @else
                        <i class="fas fa-file" style="font-size: 24px; color: #666;"></i>
                    @endif
                </div>

                <div class="media-list-info">
                    <div class="media-list-title">{{ $item->title }}</div>
                    <div class="media-list-meta">
                        {{ $item->original_filename }} • {{ $item->file_size_formatted }} • {{ ucfirst($item->file_type) }} • {{ $item->created_at->format('M d, Y') }}
                    </div>
                </div>

                <div class="media-list-actions">
                    <button onclick="showMediaDetails({{ $item->id }})" style="background: none; border: none; color: #0073aa; cursor: pointer;">
                        <i class="fas fa-edit"></i>
                    </button>
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
