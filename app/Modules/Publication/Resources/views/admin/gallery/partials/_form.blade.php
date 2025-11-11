<div class="container-fluid">
    <form id="gallery-form" action="{{ isset($data['record']->id) ? route('gallery.update', $data['record']->id) : route('gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($data['record']->id) @method('PUT') @endisset

        <!-- Category Selection -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Select Category</label>
                <select class="form-select form-select-lg" name="category_id" required>
                    <option value="">Choose Gallery Category</option>
                    @foreach($data['categories'] as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $data['record']->category_id ?? $data['selected_category'] ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Upload Type -->
        <div class="row mb-4">
            <div class="col-12">
                <label class="form-label fw-bold mb-3">What do you want to upload?</label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card h-100 upload-type-card" data-type="image" style="cursor: pointer; border: 2px solid #e9ecef;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-images fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Multiple Images</h5>
                                <p class="card-text text-muted">Upload multiple photos at once</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 upload-type-card" data-type="video" style="cursor: pointer; border: 2px solid #e9ecef;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-video fa-3x text-success mb-3"></i>
                                <h5 class="card-title">Video</h5>
                                <p class="card-text text-muted">Add video from YouTube or Vimeo</p>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="file_type" id="file_type" value="{{ old('file_type', $data['record']->file_type ?? 'image') }}">
            </div>
        </div>

        <!-- Image Upload Section -->
        <div id="image-section" class="upload-section">
            @if(isset($data['record']) && $data['record']->file_type === 'image')
                <!-- Current Image Display -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-image me-2"></i>Current Image</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="{{ asset('storage/gallery/' . $data['record']->image) }}"
                                     class="img-fluid rounded shadow" style="max-height: 120px; object-fit: cover; width: 100%;">
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">{{ $data['record']->image }}</h6>
                                <p class="mb-0 text-muted">Current caption: {{ $data['record']->caption ?? 'No caption' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Update Caption</label>
                                <input type="text" class="form-control" name="captions[]"
                                       value="{{ old('captions.0', $data['record']->caption) }}"
                                       placeholder="Enter new caption">
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cloud-upload-alt me-2"></i>
                        @if(isset($data['record']))
                            Replace Image
                        @else
                            Upload Your Images
                        @endif
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($data['record']))
                        <div class="alert alert-warning m-3 mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> Uploading a new image will replace the current one.
                        </div>
                    @endif

                    <!-- Drop Zone -->
                    <div id="drop-zone" class="text-center p-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; min-height: 200px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                        <i class="fas fa-cloud-upload-alt fa-4x mb-3 opacity-75"></i>
                        <h4 class="mb-2">
                            @if(isset($data['record']))
                                Click to Replace Image
                            @else
                                Drag & Drop Images Here
                            @endif
                        </h4>
                        <p class="mb-3 opacity-75">or click to browse files</p>
                        <button type="button" class="btn btn-light btn-lg" id="browse-btn">
                            <i class="fas fa-folder-open me-2"></i>Browse Files
                        </button>
                        <input type="file" id="images" name="images[]" multiple accept="image/*" class="d-none">
                        <small class="mt-3 opacity-75">Supports: JPG, PNG, GIF • Max: 5MB each</small>
                    </div>

                    <!-- Preview Grid -->
                    <div id="preview-grid" class="p-4" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Selected Images (<span id="image-count">0</span>)</h6>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="clear-all">
                                <i class="fas fa-trash me-1"></i>Clear All
                            </button>
                        </div>
                        <div id="image-grid" class="row g-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Video Section -->
        <div id="video-section" class="upload-section" style="display: none;">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-video me-2"></i>Add Videos</h5>
                    <button type="button" class="btn btn-light btn-sm" id="add-video-btn">
                        <i class="fas fa-plus me-1"></i>Add More
                    </button>
                </div>
                <div class="card-body p-4">
                    <div id="video-inputs-container">
                        @if(isset($data['record']) && $data['record']->file_type === 'video')
                            <div class="video-input-row row mb-3">
                                <div class="col-md-7">
                                    <label class="form-label">Video URL</label>
                                    <input type="url" class="form-control" name="video_urls[]"
                                           placeholder="https://youtube.com/watch?v=..."
                                           value="{{ old('video_urls.0', $data['record']->video_url ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Caption</label>
                                    <input type="text" class="form-control" name="video_captions[]"
                                           value="{{ old('video_captions.0', $data['record']->caption ?? '') }}"
                                           placeholder="Video description">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-video-btn" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="video-input-row row mb-3">
                                <div class="col-md-7">
                                    <label class="form-label">Video URL</label>
                                    <input type="url" class="form-control" name="video_urls[]"
                                           placeholder="https://youtube.com/watch?v=...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Caption</label>
                                    <input type="text" class="form-control" name="video_captions[]"
                                           placeholder="Video description">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-outline-danger remove-video-btn" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <small class="form-text text-muted">Paste YouTube, Vimeo, or direct video links</small>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row mt-4">
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary btn-lg px-5" id="submit-btn">
                    <i class="fas fa-save me-2"></i>Save Gallery
                </button>
            </div>
        </div>
    </form>
</div>

<style>
.upload-type-card {
    transition: all 0.3s ease;
}
.upload-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.upload-type-card.active {
    border-color: #0d6efd !important;
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
}
#drop-zone {
    transition: all 0.3s ease;
    border: 3px dashed transparent;
}
#drop-zone.drag-over {
    border-color: #fff;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}
.image-preview {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}
.image-preview img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}
.image-preview .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.caption-input {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    border: none;
    padding: 8px;
    font-size: 12px;
}
.caption-input::placeholder {
    color: #ccc;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gallery-form');
    const fileTypeInput = document.getElementById('file_type');
    const typeCards = document.querySelectorAll('.upload-type-card');
    const imageSection = document.getElementById('image-section');
    const videoSection = document.getElementById('video-section');
    const dropZone = document.getElementById('drop-zone');
    const browseBtn = document.getElementById('browse-btn');
    const imagesInput = document.getElementById('images');
    const previewGrid = document.getElementById('preview-grid');
    const imageGrid = document.getElementById('image-grid');
    const imageCount = document.getElementById('image-count');
    const clearAllBtn = document.getElementById('clear-all');
    const addVideoBtn = document.getElementById('add-video-btn');
    const videoContainer = document.getElementById('video-inputs-container');
    
    let selectedFiles = [];
    let videoCount = 1;

    // Initialize
    updateActiveType();

    // Type selection
    typeCards.forEach(card => {
        card.addEventListener('click', () => {
            const type = card.dataset.type;
            fileTypeInput.value = type;
            updateActiveType();
        });
    });

    function updateActiveType() {
        const activeType = fileTypeInput.value;
        
        typeCards.forEach(card => {
            card.classList.toggle('active', card.dataset.type === activeType);
        });
        
        if (activeType === 'video') {
            imageSection.style.display = 'none';
            videoSection.style.display = 'block';
        } else {
            imageSection.style.display = 'block';
            videoSection.style.display = 'none';
        }
    }

    // File upload handlers
    if (browseBtn) {
        browseBtn.addEventListener('click', (e) => {
            e.preventDefault();
            imagesInput.click();
        });
    }
    
    if (dropZone) {
        dropZone.addEventListener('click', (e) => {
            if (e.target !== browseBtn) {
                imagesInput.click();
            }
        });
    }

    // Drag and drop
    if (dropZone) {
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
            if (files.length > 0) {
                addFiles(files);
            }
        });
    }

    if (imagesInput) {
        imagesInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            if (files.length > 0) {
                selectedFiles = files; // Replace instead of append for single file mode
                updateFileInput();
                renderPreviews();
            }
        });
    }

    function addFiles(files) {
        selectedFiles = [...selectedFiles, ...files];
        updateFileInput();
        renderPreviews();
    }

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imagesInput.files = dt.files;
    }

    function renderPreviews() {
        if (selectedFiles.length === 0) {
            if (previewGrid) previewGrid.style.display = 'none';
            return;
        }

        if (previewGrid) previewGrid.style.display = 'block';
        if (imageCount) imageCount.textContent = selectedFiles.length;
        if (imageGrid) imageGrid.innerHTML = '';

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const col = document.createElement('div');
                col.className = 'col-md-3 col-sm-4 col-6';
                col.innerHTML = `
                    <div class="image-preview">
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeFile(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                        <input type="text" class="caption-input" name="captions[]" placeholder="Add caption...">
                    </div>
                `;
                if (imageGrid) imageGrid.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removeFile = function(index) {
        selectedFiles.splice(index, 1);
        updateFileInput();
        renderPreviews();
    };

    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', () => {
            selectedFiles = [];
            updateFileInput();
            renderPreviews();
        });
    }

    // Video URL management
    if (addVideoBtn) {
        addVideoBtn.addEventListener('click', () => {
            addVideoInput();
        });
    }

    function addVideoInput() {
        videoCount++;
        const newRow = document.createElement('div');
        newRow.className = 'video-input-row row mb-3';
        newRow.innerHTML = `
            <div class="col-md-7">
                <label class="form-label">Video URL</label>
                <input type="url" class="form-control" name="video_urls[]"
                       placeholder="https://youtube.com/watch?v=...">
            </div>
            <div class="col-md-4">
                <label class="form-label">Caption</label>
                <input type="text" class="form-control" name="video_captions[]"
                       placeholder="Video description">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger remove-video-btn">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        
        if (videoContainer) {
            videoContainer.appendChild(newRow);
            updateRemoveButtons();
        }
    }

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-video-btn');
        const videoRows = document.querySelectorAll('.video-input-row');
        
        removeButtons.forEach((btn, index) => {
            btn.disabled = videoRows.length === 1;
            btn.onclick = () => {
                if (videoRows.length > 1) {
                    btn.closest('.video-input-row').remove();
                    videoCount--;
                    updateRemoveButtons();
                }
            };
        });
    }

    // Initialize remove buttons
    updateRemoveButtons();
});
</script>

