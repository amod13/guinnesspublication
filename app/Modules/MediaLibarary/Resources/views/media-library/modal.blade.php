@extends('admin.main.app')
@section('content')
<style>
.media-modal-library {
    background: #fff;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.media-modal-toolbar {
    background: #f1f1f1;
    border-bottom: 1px solid #ddd;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
}

.media-modal-filters {
    display: flex;
    gap: 10px;
    align-items: center;
}

.media-modal-search input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 200px;
}

.media-modal-type select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.media-modal-upload {
    background: #0073aa;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
}

.media-modal-content {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
}

.media-modal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
}

.media-modal-item {
    border: 2px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
    background: #f9f9f9;
}

.media-modal-item:hover {
    border-color: #0073aa;
}

.media-modal-item.selected {
    border-color: #0073aa;
    background: #e6f3ff;
}

.media-modal-thumbnail {
    width: 100%;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
}

.media-modal-thumbnail img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.media-modal-thumbnail .file-icon {
    font-size: 32px;
    color: #666;
}

.media-modal-info {
    padding: 8px;
    text-align: center;
}

.media-modal-title {
    font-size: 11px;
    font-weight: 500;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.media-modal-actions {
    background: #f1f1f1;
    border-top: 1px solid #ddd;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.media-modal-selected {
    font-size: 13px;
    color: #666;
}

.media-modal-buttons {
    display: flex;
    gap: 10px;
}

.media-modal-btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 13px;
}

.media-modal-btn-primary {
    background: #0073aa;
    color: white;
}

.media-modal-btn-secondary {
    background: #f1f1f1;
    color: #333;
    border: 1px solid #ddd;
}

.media-upload-area {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    margin-bottom: 20px;
    transition: all 0.2s;
}

.media-upload-area.dragover {
    border-color: #0073aa;
    background: #f0f6fc;
}

.empty-modal-state {
    text-align: center;
    padding: 40px 20px;
    color: #666;
}
</style>

<div class="media-modal-library">
    <!-- Toolbar -->
    <div class="media-modal-toolbar">
        <div class="media-modal-filters">
            <div class="media-modal-search">
                <input type="text" id="modal-search" placeholder="Search media...">
            </div>
            <div class="media-modal-type">
                <select id="modal-type-filter">
                    <option value="all">All types</option>
                    <option value="image">Images</option>
                    <option value="video">Videos</option>
                    <option value="audio">Audio</option>
                    <option value="document">Documents</option>
                </select>
            </div>
        </div>
        <button class="media-modal-upload" onclick="document.getElementById('modal-file-upload').click()">
            <i class="fas fa-upload"></i> Upload Files
        </button>
    </div>

    <!-- Content -->
    <div class="media-modal-content">
        <!-- Upload Area -->
        <div class="media-upload-area" id="modal-upload-area">
            <h4>Drop files to upload</h4>
            <p>or <a href="#" onclick="document.getElementById('modal-file-upload').click()">select files</a></p>
        </div>

        <!-- Media Grid -->
        <div id="modal-media-container">
            @if($mediaItems->count() > 0)
                <div class="media-modal-grid">
                    @foreach($mediaItems as $item)
                        <div class="media-modal-item" data-id="{{ $item->id }}" data-url="{{ $item->url }}" data-title="{{ $item->title }}" onclick="selectMediaItem(this)">
                            <div class="media-modal-thumbnail">
                                @if($item->isImage())
                                    <img src="{{ $item->url }}" alt="{{ $item->alt_text }}">
                                @elseif($item->isVideo())
                                    <i class="fas fa-video file-icon"></i>
                                @elseif($item->isAudio())
                                    <i class="fas fa-music file-icon"></i>
                                @else
                                    <i class="fas fa-file file-icon"></i>
                                @endif
                            </div>
                            <div class="media-modal-info">
                                <h5 class="media-modal-title">{{ $item->title }}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($mediaItems->hasPages())
                    <div style="margin-top: 20px;">
                        {{ $mediaItems->links() }}
                    </div>
                @endif
            @else
                <div class="empty-modal-state">
                    <i class="fas fa-images" style="font-size: 48px; margin-bottom: 15px; color: #ddd;"></i>
                    <h4>No media files found</h4>
                    <p>Upload your first media file to get started.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="media-modal-actions">
        <div class="media-modal-selected" id="modal-selected-info">
            Select a media item
        </div>
        <div class="media-modal-buttons">
            <button class="media-modal-btn media-modal-btn-secondary" onclick="closeMediaLibraryModal()">Cancel</button>
            <button class="media-modal-btn media-modal-btn-primary" id="modal-select-btn" onclick="insertSelectedMedia()" disabled>Insert Media</button>
        </div>
    </div>
</div>

<!-- Hidden file input -->
<input type="file" id="modal-file-upload" multiple style="display: none;">

<script>
let selectedMediaItem = null;

$(document).ready(function() {
    initializeModalUpload();
    initializeModalSearch();
});

function initializeModalUpload() {
    const uploadArea = document.getElementById('modal-upload-area');
    const fileInput = document.getElementById('modal-file-upload');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        uploadModalFiles(e.dataTransfer.files);
    });

    fileInput.addEventListener('change', (e) => {
        uploadModalFiles(e.target.files);
    });
}

function uploadModalFiles(files) {
    if (files.length === 0) return;

    const formData = new FormData();
    for (let file of files) {
        formData.append('files[]', file);
    }

    $.ajax({
        url: '{{ route("media-library.upload") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        }
    });
}

function initializeModalSearch() {
    let searchTimeout;

    $('#modal-search').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterModalMedia();
        }, 500);
    });

    $('#modal-type-filter').on('change', function() {
        filterModalMedia();
    });
}

function filterModalMedia() {
    const search = $('#modal-search').val();
    const type = $('#modal-type-filter').val();

    $.ajax({
        url: '{{ route("media-library.modal") }}',
        data: { search, type },
        success: function(response) {
            $('#modal-media-container').html($(response).find('#modal-media-container').html());
            selectedMediaItem = null;
            updateModalSelection();
        }
    });
}

function selectMediaItem(element) {
    // Remove previous selection
    $('.media-modal-item').removeClass('selected');

    // Add selection to clicked item
    $(element).addClass('selected');

    // Store selected item data
    selectedMediaItem = {
        id: $(element).data('id'),
        url: $(element).data('url'),
        title: $(element).data('title')
    };

    updateModalSelection();
}

function updateModalSelection() {
    const selectBtn = document.getElementById('modal-select-btn');
    const selectedInfo = document.getElementById('modal-selected-info');

    if (selectedMediaItem) {
        selectBtn.disabled = false;
        selectedInfo.textContent = `Selected: ${selectedMediaItem.title}`;
    } else {
        selectBtn.disabled = true;
        selectedInfo.textContent = 'Select a media item';
    }
}

function insertSelectedMedia() {
    if (selectedMediaItem && window.parent.insertMediaCallback) {
        window.parent.insertMediaCallback(selectedMediaItem);
        closeMediaLibraryModal();
    }
}

function closeMediaLibraryModal() {
    if (window.parent.closeMediaLibraryModal) {
        window.parent.closeMediaLibraryModal();
    }
}
</script>
@endsection
