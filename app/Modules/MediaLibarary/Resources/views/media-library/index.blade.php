@extends('admin.main.app')
@section('content')
    <style>
        .media-library {
            background: #fff;
            min-height: 100vh;
        }

        .media-toolbar {
            background: #f1f1f1;
            border-bottom: 1px solid #ddd;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .media-filters {
            display: flex;
            gap: 10px;
            align-items: center;
            flex: 1;
        }

        .media-search input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }

        .media-type-filter select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .upload-btn {
            background: #0073aa;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .upload-btn:hover {
            background: #005a87;
        }

        .media-content {
            padding: 20px;
        }

        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .media-item {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .media-item:hover {
            border-color: #0073aa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .media-item.selected {
            border-color: #0073aa;
            box-shadow: 0 0 0 2px rgba(0, 115, 170, 0.3);
        }

        .media-thumbnail {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
        }

        .media-thumbnail img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .media-thumbnail .file-icon {
            font-size: 48px;
            color: #666;
        }

        .media-info {
            padding: 10px;
            background: white;
        }

        .media-title {
            font-size: 12px;
            font-weight: 500;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .media-meta {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
        }

        .media-checkbox {
            position: absolute;
            top: 8px;
            left: 8px;
            z-index: 2;
        }

        .bulk-actions {
            display: none;
            background: #f1f1f1;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
            align-items: center;
            gap: 10px;
        }

        .bulk-actions.show {
            display: flex;
        }

        .bulk-delete-btn {
            background: #dc3232;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .media-media-upload-area {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 3px dashed rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 7px 16px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .media-media-upload-area::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }

        .media-media-upload-area.dragover {
            border-color: rgba(255, 255, 255, 0.8);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }

        .upload-zone {
            position: relative;
            z-index: 2;
        }

        .upload-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.9;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .upload-text {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .upload-subtext {
            font-size: 1rem;
            opacity: 0.8;
            margin-bottom: 25px;
        }

        .upload-browse-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .upload-browse-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }

        .upload-formats {
            margin-top: 20px;
            font-size: 0.85rem;
            opacity: 0.7;
        }

        .upload-header {
            position: relative;
            margin-bottom: 0;
        }

        .close-upload {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            z-index: 3;
        }

        .close-upload:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: rotate(90deg) scale(1.1);
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            display: flex;
            align-items: stretch;
            justify-content: center;
        }

        .modal-content {
            background: white;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 15px 20px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
            flex-shrink: 0;
        }

        .modal-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .modal-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-btn {
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .nav-btn:hover:not(:disabled) {
            background: #e0e0e0;
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .copy-url-btn {
            background: #0073aa;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .copy-url-btn:hover {
            background: #005a87;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
        }

        .modal-close:hover {
            background: #f0f0f0;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .view-switch {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .view-switch button {
            background: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-right: 1px solid #ddd;
            transition: all 0.2s;
        }

        .view-switch button:last-child {
            border-right: none;
        }

        .view-switch button:hover {
            background: #f0f0f0;
        }

        .view-switch button.current {
            background: #0073aa;
            color: white;
        }

        .media-list {
            margin-top: 20px;
        }

        .media-list-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }

        .media-list-item:hover {
            background: #f9f9f9;
        }

        .media-list-item.selected {
            background: #e6f3ff;
        }

        .media-list-thumbnail {
            width: 60px;
            height: 60px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
            border-radius: 4px;
        }

        .media-list-thumbnail img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .media-list-info {
            flex: 1;
        }

        .media-list-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .media-list-meta {
            font-size: 12px;
            color: #666;
        }

        .media-list-actions {
            margin-left: 15px;
        }

        .media-container.list-view .media-grid {
            display: none;
        }

        .media-container.grid-view .media-list {
            display: none;
        }

        .media-checkbox {
            display: none;
        }

        .bulk-select-mode .media-checkbox {
            display: block;
        }

        .select-mode-toggle-button.active {
            background: #0073aa !important;
            color: white !important;
            border-color: #0073aa !important;
        }

        .bulk-select-options {
            display: none;
            gap: 10px;
            align-items: center;
        }

        .bulk-select-options.show {
            display: flex;
        }

        .bulk-select-btn {
            background: #f1f1f1;
            border: 1px solid #ddd;
            color: #333;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
        }

        .bulk-select-btn:hover {
            background: #e0e0e0;
            border-color: #bbb;
        }

        .bulk-select-btn.primary {
            background: #0073aa;
            color: white;
            border-color: #0073aa;
        }

        .bulk-select-btn.primary:hover {
            background: #005a87;
            border-color: #005a87;
        }

        .bulk-select-btn.secondary {
            background: #666;
            color: white;
            border-color: #666;
        }

        .bulk-select-btn.secondary:hover {
            background: #555;
            border-color: #555;
        }
    </style>

    <div class="media-library">
        <!-- Toolbar -->
        <div class="media-toolbar">
            <div class="media-filters">
                <div class="media-search">
                    <input type="text" id="media-search" placeholder="Search media..." value="{{ request('search') }}">
                </div>
                <div class="media-type-filter">
                    <select id="media-type-filter">
                        <option value="all">All media items</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                        <option value="audio">Audio</option>
                        <option value="document">Documents</option>
                    </select>
                </div>
                <div class="bulk-select-toggle">
                    <button type="button" class="button media-button select-mode-toggle-button" id="bulk-select-toggle"
                        onclick="toggleBulkSelectMode()"
                        style="background: #f1f1f1; border: 1px solid #ddd; padding: 8px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; color: #333;">Bulk
                        select</button>
                </div>
                <div class="bulk-select-options" id="bulk-select-options">
                    <button type="button" class="bulk-select-btn primary" onclick="selectAll()">
                        Select All
                    </button>
                    <button type="button" class="bulk-select-btn secondary" onclick="selectNone()">
                        Select None
                    </button>
                </div>
            </div>
            <div class="view-switch">
                <button class="view-grid current" id="view-switch-grid" onclick="switchView('grid')" title="Grid view">
                    <i class="fas fa-th"></i>
                </button>
                <button class="view-list" id="view-switch-list" onclick="switchView('list')" title="List view">
                    <i class="fas fa-list"></i>
                </button>
            </div>
            <div class="media-actions">
                <button class="upload-btn" onclick="showUploadArea()">
                    <i class="fas fa-upload"></i> Add New
                </button>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulk-actions">
            <span class="selected-count" id="selected-count">0 items selected</span>
            <button class="bulk-delete-btn" onclick="bulkDelete()">Delete Selected</button>
        </div>

        <!-- Content -->
        <div class="media-content">
            <!-- Upload Area -->
            <div class="media-media-upload-area" id="media-media-upload-area" style="display: none;">
                <div class="upload-header">
                    <button class="close-upload" onclick="hideUploadArea()">&times;</button>
                </div>
                <div class="upload-zone">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Drop your files here</div>
                    <div class="upload-subtext">or click to browse from your computer</div>
                    <a href="#" class="upload-browse-btn" onclick="document.getElementById('file-upload').click()">
                        <i class="fas fa-folder-open"></i> Browse Files
                    </a>
                    <div class="upload-formats">
                        Supports: Images, Videos, Audio, Documents (Max 10MB each)
                    </div>
                </div>
            </div>

            <!-- Media Grid -->
            <div id="media-container" class="media-container grid-view">
                @include('medialibarary::media-library.partials.grid', ['mediaItems' => $mediaItems])
            </div>
        </div>
    </div>

    <!-- Hidden file input -->
    <input type="file" id="file-upload" multiple style="display: none;">

    <!-- Media Details Modal -->
    <div id="media-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-nav">
                    <button class="nav-btn" id="prev-media" onclick="navigateMedia('prev')" title="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <h3>Attachment details</h3>
                    <button class="nav-btn" id="next-media" onclick="navigateMedia('next')" title="Next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="modal-actions">
                    <button class="copy-url-btn" onclick="copyMediaUrl()" title="Copy URL">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button class="modal-close" onclick="closeMediaModal()">&times;</button>
                </div>
            </div>
            <div class="modal-body" id="media-modal-content">
            </div>
        </div>
    </div>

    <!-- Image Edit Modal -->
    <div id="image-edit-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Image</h3>
                <button class="modal-close" onclick="closeImageEditModal()">&times;</button>
            </div>
            <div class="modal-body" id="image-edit-content" style="padding: 20px;">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Ensure variables are not redeclared
        if (typeof selectedItems === 'undefined') {
            var selectedItems = new Set();
        }
        if (typeof currentMediaId === 'undefined') {
            var currentMediaId = null;
        }
        if (typeof mediaList === 'undefined') {
            var mediaList = [];
        }
        if (typeof bulkSelectMode === 'undefined') {
            var bulkSelectMode = false;
        }

        $(document).ready(function() {
            initializeUpload();
            initializeSearch();
            initializeSelection();
            initializeViewState();
        });

        function initializeViewState() {
            const savedView = localStorage.getItem('media-library-view') || 'grid';
            const container = $('#media-container');
            const gridBtn = $('#view-switch-grid');
            const listBtn = $('#view-switch-list');

            if (savedView === 'list') {
                container.removeClass('grid-view').addClass('list-view');
                listBtn.addClass('current');
                gridBtn.removeClass('current');
                loadView('list');
            }
        }

        function initializeUpload() {
            const uploadArea = document.getElementById('media-media-upload-area');
            const fileInput = document.getElementById('file-upload');

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
                uploadFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', (e) => {
                uploadFiles(e.target.files);
            });
        }

        let isUploading = false;

        async function uploadFiles(files) {
            if (isUploading || files.length === 0) return;
            isUploading = true;

            const uploadArea = document.getElementById('media-media-upload-area');
            const originalContent = uploadArea.innerHTML;

            try {
                for (let file of files) {
                    await uploadFileWithChunks(file, uploadArea);
                }

                uploadArea.innerHTML = originalContent;
                alert('All files uploaded successfully!');
                hideUploadArea();
                location.reload();
            } catch (error) {
                uploadArea.innerHTML = originalContent;
                alert('Upload failed: ' + error.message);
            } finally {
                isUploading = false;
            }
        }

        async function uploadFileWithChunks(file, uploadArea) {
            const CHUNK_SIZE = 1024 * 1024; // 1MB chunks
            const totalChunks = Math.ceil(file.size / CHUNK_SIZE);
            const fileId = Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
                const start = chunkIndex * CHUNK_SIZE;
                const end = Math.min(start + CHUNK_SIZE, file.size);
                const chunk = file.slice(start, end);

                const formData = new FormData();
                formData.append('chunk', chunk);
                formData.append('chunkIndex', chunkIndex);
                formData.append('totalChunks', totalChunks);
                formData.append('fileId', fileId);
                formData.append('fileName', file.name);
                formData.append('fileSize', file.size);
                formData.append('mimeType', file.type);

                // Update progress
                const progress = Math.round(((chunkIndex + 1) / totalChunks) * 100);
                const uploadChunkUrl = "{{ route('media-library.upload-chunk') }}";
                uploadArea.innerHTML = `
                    <div class="upload-progress">
                        <h3 style="margin-bottom: 15px; color: #333;">Uploading ${file.name}</h3>
                        <div class="progress-container" style="background: #e9ecef; border-radius: 10px; padding: 4px; margin-bottom: 10px;">
                            <div class="progress-bar" style="background: linear-gradient(90deg, #0073aa, #005a87); height: 20px; border-radius: 6px; width: ${progress}%; transition: width 0.3s ease; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: bold;">
                                ${progress}%
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 13px; color: #666;">
                            <span>Chunk ${chunkIndex + 1} of ${totalChunks}</span>
                            <span>${(file.size / 1024 / 1024).toFixed(1)} MB</span>
                        </div>
                    </div>
                `;

                let retries = 3;
                while (retries > 0) {
                    try {
                        await new Promise((resolve, reject) => {
                            $.ajax({
                                url: uploadChunkUrl,
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                timeout: 30000,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: resolve,
                                error: (xhr) => reject(new Error(xhr.responseJSON?.message ||
                                    'Chunk upload failed'))
                            });
                        });
                        break;
                    } catch (error) {
                        retries--;
                        if (retries === 0) throw error;
                        await new Promise(resolve => setTimeout(resolve, 1000));
                    }
                }
            }
        }

        function initializeSearch() {
            let searchTimeout;

            $('#media-search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterMedia();
                }, 500);
            });

            $('#media-type-filter').on('change', function() {
                filterMedia();
            });
        }

        function filterMedia() {
            const search = $('#media-search').val();
            const type = $('#media-type-filter').val();
            const currentView = localStorage.getItem('media-library-view') || 'grid';

            $.ajax({
                url: '{{ route('media-library.index') }}',
                data: {
                    search,
                    type,
                    view: currentView
                },
                success: function(response) {
                    if (response.success) {
                        $('#media-container').html(response.html);
                        selectedItems.clear();
                        updateBulkActions();
                    }
                }
            });
        }

        function initializeSelection() {
            $(document).on('change', '.media-checkbox', function() {
                const itemId = $(this).data('id');
                const mediaItem = $(this).closest('.media-item, .media-list-item');

                if (this.checked) {
                    selectedItems.add(itemId);
                    mediaItem.addClass('selected');
                } else {
                    selectedItems.delete(itemId);
                    mediaItem.removeClass('selected');
                }

                updateBulkActions();
            });

            // Handle media item clicks to toggle checkbox
            $(document).on('click', '.media-item, .media-list-item', function(e) {
                // Don't toggle if clicking on checkbox or action buttons
                if ($(e.target).is('.media-checkbox') || $(e.target).closest('.media-actions, .media-list-actions')
                    .length) {
                    return;
                }

                // Only toggle checkbox if in bulk select mode
                if (bulkSelectMode) {
                    const checkbox = $(this).find('.media-checkbox');
                    if (checkbox.length) {
                        checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                    }
                }
            });

            // Handle double-click to show media details
            $(document).on('dblclick', '.media-item, .media-list-item', function(e) {
                const itemId = $(this).data('id') || $(this).find('.media-checkbox').data('id');
                if (itemId) {
                    showMediaDetails(itemId);
                }
            });

            // Handle pagination clicks
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    loadPaginationPage(url);
                }
            });
        }

        function updateBulkActions() {
            const count = selectedItems.size;
            $('#selected-count').text(count + ' item' + (count !== 1 ? 's' : '') + ' selected');

            if (count > 0) {
                $('#bulk-actions').addClass('show');
            } else {
                $('#bulk-actions').removeClass('show');
            }
        }

        function showMediaDetails(id) {
            currentMediaId = parseInt(id);

            // Build media list from current view
            mediaList = [];
            $('.media-item, .media-list-item').each(function() {
                const itemId = $(this).find('.media-checkbox').data('id');
                if (itemId) mediaList.push(parseInt(itemId));
            });

            $.ajax({
                url: '{{ route('media-library.details', ':id') }}'.replace(':id', id),
                cache: false, // Disable caching to get fresh data
                headers: {
                    'Cache-Control': 'no-cache, no-store, must-revalidate',
                    'Pragma': 'no-cache',
                    'Expires': '0'
                },
                success: function(html) {
                    $('#media-modal-content').html(html);
                    updateNavigationButtons();
                    $('#media-modal').show();
                },
                error: function() {
                    alert('Failed to load media details');
                }
            });
        }

        function closeMediaModal() {
            $('#media-modal').hide();
        }

        function showUploadArea() {
            $('#media-media-upload-area').slideDown(300);
        }

        function hideUploadArea() {
            $('#media-media-upload-area').slideUp(300);
        }

        function updateNavigationButtons() {
            const currentIndex = mediaList.indexOf(currentMediaId);
            $('#prev-media').prop('disabled', currentIndex <= 0);
            $('#next-media').prop('disabled', currentIndex >= mediaList.length - 1);
        }

        function navigateMedia(direction) {
            const currentIndex = mediaList.indexOf(currentMediaId);
            let newIndex;

            if (direction === 'prev' && currentIndex > 0) {
                newIndex = currentIndex - 1;
            } else if (direction === 'next' && currentIndex < mediaList.length - 1) {
                newIndex = currentIndex + 1;
            } else {
                return;
            }

            const newMediaId = mediaList[newIndex];
            showMediaDetails(newMediaId);
        }

        function copyMediaUrl() {
            $.ajax({
                url: '{{ route('media-library.show', ':id') }}'.replace(':id', currentMediaId),
                success: function(media) {
                    // Try modern clipboard API first
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(media.url).then(function() {
                            showCopySuccess();
                        }).catch(function() {
                            fallbackCopyToClipboard(media.url);
                        });
                    } else {
                        fallbackCopyToClipboard(media.url);
                    }
                }
            });
        }

        function showCopySuccess() {
            const btn = $('.copy-url-btn');
            const originalHtml = btn.html();
            btn.html('<i class="fas fa-check"></i>').css('background', '#28a745');
            setTimeout(() => {
                btn.html(originalHtml).css('background', '#0073aa');
            }, 1500);
        }

        function fallbackCopyToClipboard(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess();
                } else {
                    alert('Failed to copy URL to clipboard');
                }
            } catch (err) {
                alert('Failed to copy URL to clipboard');
            }

            document.body.removeChild(textArea);
        }

        function editImage(id) {
            // Load image edit interface in modal
            $.ajax({
                url: '{{ route('media-library.edit-image', ':id') }}'.replace(':id', id),
                success: function(html) {
                    $('#image-edit-content').html(html);
                    $('#image-edit-modal').show();
                },
                error: function() {
                    alert('Failed to load image editor');
                }
            });
        }

        function closeImageEditModal() {
            // Destroy cropper instance to prevent conflicts
            if (window.modalCropper) {
                window.modalCropper.destroy();
                window.modalCropper = null;
            }
            $('#image-edit-modal').hide();
            $('#image-edit-content').empty();
        }

        function updateAttachmentImage(mediaId, newMediaId) {
            // Close current modal and show new media if new ID provided
            if (newMediaId) {
                closeMediaModal();
                setTimeout(() => {
                    showMediaDetails(newMediaId);
                    // Refresh the main grid to show new image
                    filterMedia();
                }, 300);
            } else {
                // Fallback: refresh current modal
                const modalContent = $('#media-modal-content');
                modalContent.css('opacity', '0.7');

                $.ajax({
                    url: '{{ route('media-library.details', ':id') }}'.replace(':id', mediaId),
                    success: function(html) {
                        modalContent.html(html).css('opacity', '1');
                    },
                    error: function() {
                        modalContent.css('opacity', '1');
                    }
                });
            }
        }

        function loadPaginationPage(url) {
            const search = $('#media-search').val();
            const type = $('#media-type-filter').val();
            const currentView = localStorage.getItem('media-library-view') || 'grid';

            // Add view parameter to URL
            const urlObj = new URL(url);
            urlObj.searchParams.set('view', currentView);
            if (search) urlObj.searchParams.set('search', search);
            if (type && type !== 'all') urlObj.searchParams.set('type', type);

            $.ajax({
                url: urlObj.toString(),
                success: function(response) {
                    if (response.success) {
                        $('#media-container').html(response.html);
                        selectedItems.clear();
                        updateBulkActions();
                    }
                }
            });
        }

        function switchView(view) {
            const container = $('#media-container');
            const gridBtn = $('#view-switch-grid');
            const listBtn = $('#view-switch-list');

            // Save view preference
            localStorage.setItem('media-library-view', view);

            if (view === 'grid') {
                container.removeClass('list-view').addClass('grid-view');
                gridBtn.addClass('current');
                listBtn.removeClass('current');
                loadView('grid');
            } else {
                container.removeClass('grid-view').addClass('list-view');
                listBtn.addClass('current');
                gridBtn.removeClass('current');
                loadView('list');
            }
        }

        function loadView(view) {
            const search = $('#media-search').val();
            const type = $('#media-type-filter').val();

            $.ajax({
                url: '{{ route('media-library.index') }}',
                data: {
                    search,
                    type,
                    view
                },
                success: function(response) {
                    if (response.success) {
                        $('#media-container').html(response.html);
                        selectedItems.clear();
                        updateBulkActions();
                    }
                }
            });
        }

        $(document).on('submit', '#media-form', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('media-library.update', ':id') }}'.replace(':id', id),
                method: 'PUT',
                data: Object.fromEntries(formData),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        closeMediaModal();
                        filterMedia();
                    }
                }
            });
        });

        function deleteMedia(id) {
            if (confirm('Are you sure you want to delete this media item?')) {
                $.ajax({
                    url: '{{ route('media-library.destroy', ':id') }}'.replace(':id', id),
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            closeMediaModal();
                            filterMedia();
                        }
                    }
                });
            }
        }

        function bulkDelete() {
            if (selectedItems.size === 0) return;

            if (confirm(`Are you sure you want to delete ${selectedItems.size} item(s)?`)) {
                $.ajax({
                    url: '{{ route('media-library.bulk-delete') }}',
                    method: 'DELETE',
                    data: {
                        ids: Array.from(selectedItems)
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            selectedItems.clear();
                            filterMedia();
                        }
                    }
                });
            }
        }

        function selectAll() {
            $('.media-checkbox').each(function() {
                if (!this.checked) {
                    $(this).prop('checked', true).trigger('change');
                }
            });
        }

        function selectNone() {
            $('.media-checkbox').each(function() {
                if (this.checked) {
                    $(this).prop('checked', false).trigger('change');
                }
            });
        }

        function toggleBulkSelectMode() {
            bulkSelectMode = !bulkSelectMode;
            const toggleBtn = $('#bulk-select-toggle');
            const bulkOptions = $('#bulk-select-options');
            const mediaLibrary = $('.media-library');

            if (bulkSelectMode) {
                toggleBtn.addClass('active').text('Cancel');
                bulkOptions.addClass('show');
                mediaLibrary.addClass('bulk-select-mode');
            } else {
                toggleBtn.removeClass('active').text('Bulk select');
                bulkOptions.removeClass('show');
                mediaLibrary.removeClass('bulk-select-mode');
                // Clear all selections when exiting bulk mode
                selectNone();
            }
        }
    </script>
@endpush
