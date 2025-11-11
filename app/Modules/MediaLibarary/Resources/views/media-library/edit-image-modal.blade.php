<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<style>
.modal-image-editor {
    height: 70vh;
    display: flex;
    gap: 20px;
}

.modal-image-container {
    flex: 1;
    overflow: hidden;
}

.modal-editor-sidebar {
    width: 250px;
    background: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    overflow-y: auto;
}

.modal-editor-toolbar {
    display: flex;
    gap: 8px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.modal-editor-btn {
    background: #0073aa;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
}

.modal-editor-btn:hover {
    background: #005a87;
}

.modal-editor-btn.secondary {
    background: #666;
}

.modal-control-group {
    margin-bottom: 15px;
}

.modal-control-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    font-size: 13px;
}

.modal-control-group input[type="range"] {
    width: 100%;
}

.modal-preset-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 5px;
    margin-top: 8px;
}

.modal-preset-btn {
    background: #f1f1f1;
    border: 1px solid #ddd;
    padding: 6px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 11px;
}

.modal-preset-btn:hover {
    background: #e0e0e0;
}

.modal-save-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #ddd;
}
</style>

<div class="modal-image-editor">
    <div class="modal-image-container">
        <img id="modal-image-editor" src="{{ $media->url }}" alt="{{ $media->title }}" style="max-width: 100%; max-height: 100%;">
    </div>

    <div class="modal-editor-sidebar">
        <div class="modal-editor-toolbar">
            <button class="modal-editor-btn" onclick="modalRotateLeft()">
                <i class="fas fa-undo"></i>
            </button>
            <button class="modal-editor-btn" onclick="modalRotateRight()">
                <i class="fas fa-redo"></i>
            </button>
            <button class="modal-editor-btn" onclick="modalFlipHorizontal()">
                <i class="fas fa-arrows-alt-h"></i>
            </button>
            <button class="modal-editor-btn" onclick="modalFlipVertical()">
                <i class="fas fa-arrows-alt-v"></i>
            </button>
            <button class="modal-editor-btn secondary" onclick="modalResetImage()">
                <i class="fas fa-undo"></i> Reset
            </button>
        </div>

        <div class="modal-control-group">
            <label>Crop Presets</label>
            <div class="modal-preset-buttons">
                <button class="modal-preset-btn" onclick="modalSetCropRatio(1)">Square</button>
                <button class="modal-preset-btn" onclick="modalSetCropRatio(16/9)">16:9</button>
                <button class="modal-preset-btn" onclick="modalSetCropRatio(4/3)">4:3</button>
                <button class="modal-preset-btn" onclick="modalSetCropRatio(3/2)">3:2</button>
                <button class="modal-preset-btn" onclick="modalSetCropRatio(0)">Free</button>
                <button class="modal-preset-btn" onclick="modalSetCropRatio(9/16)">9:16</button>
            </div>
        </div>

        <div class="modal-control-group">
            <label for="modal-zoom-range">Zoom: <span id="modal-zoom-value">100%</span></label>
            <input type="range" id="modal-zoom-range" min="0.1" max="3" step="0.1" value="1" onchange="modalZoomImage(this.value)">
        </div>

        <div class="modal-control-group">
            <label for="modal-rotate-range">Rotate: <span id="modal-rotate-value">0°</span></label>
            <input type="range" id="modal-rotate-range" min="-180" max="180" step="1" value="0" onchange="modalRotateImage(this.value)">
        </div>

        <div class="modal-save-actions">
            <button class="modal-editor-btn" onclick="modalSaveImage({{ $media->id }})" style="flex: 1;">Save Changes</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
// Make modalCropper globally accessible (avoid redeclaration)
if (typeof window.modalCropper === 'undefined') {
    window.modalCropper = null;
}

// Initialize cropper when modal content is loaded
setTimeout(function() {
    initializeModalCropper();
}, 100);

function initializeModalCropper() {
    const image = document.getElementById('modal-image-editor');
    if (!image) return;

    // Destroy existing cropper if any
    if (window.modalCropper) {
        window.modalCropper.destroy();
    }

    window.modalCropper = new Cropper(image, {
        viewMode: 1,
        dragMode: 'crop',
        aspectRatio: NaN,
        autoCropArea: 1,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false
    });
}

function modalSetCropRatio(ratio) {
    if (window.modalCropper) {
        window.modalCropper.setAspectRatio(ratio);
    }
}

function modalZoomImage(value) {
    if (window.modalCropper) {
        window.modalCropper.zoomTo(value);
        document.getElementById('modal-zoom-value').textContent = Math.round(value * 100) + '%';
    }
}

function modalRotateImage(value) {
    if (window.modalCropper) {
        window.modalCropper.rotateTo(value);
        document.getElementById('modal-rotate-value').textContent = value + '°';
    }
}

function modalRotateLeft() {
    if (window.modalCropper) {
        window.modalCropper.rotate(-90);
        updateModalRotateSlider();
    }
}

function modalRotateRight() {
    if (window.modalCropper) {
        window.modalCropper.rotate(90);
        updateModalRotateSlider();
    }
}

function modalFlipHorizontal() {
    if (window.modalCropper) {
        const imageData = window.modalCropper.getImageData();
        window.modalCropper.scaleX(imageData.scaleX === 1 ? -1 : 1);
    }
}

function modalFlipVertical() {
    if (window.modalCropper) {
        const imageData = window.modalCropper.getImageData();
        window.modalCropper.scaleY(imageData.scaleY === 1 ? -1 : 1);
    }
}

function modalResetImage() {
    if (window.modalCropper) {
        window.modalCropper.reset();
        document.getElementById('modal-zoom-range').value = 1;
        document.getElementById('modal-rotate-range').value = 0;
        document.getElementById('modal-zoom-value').textContent = '100%';
        document.getElementById('modal-rotate-value').textContent = '0°';
    }
}

function updateModalRotateSlider() {
    if (window.modalCropper) {
        const imageData = window.modalCropper.getImageData();
        document.getElementById('modal-rotate-range').value = imageData.rotate;
        document.getElementById('modal-rotate-value').textContent = imageData.rotate + '°';
    }
}

function modalSaveImage(mediaId) {
    if (!window.modalCropper) {
        alert('Image editor not ready. Please wait.');
        return;
    }

    const canvas = window.modalCropper.getCroppedCanvas({
        maxWidth: 2000,
        maxHeight: 2000,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });

    canvas.toBlob(function(blob) {
        const formData = new FormData();
        formData.append('image', blob, 'edited_image.jpg');

        $.ajax({
            url: '{{ route("media-library.save-image", ":id") }}'.replace(':id', mediaId),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message || 'Image saved successfully!');
                    closeImageEditModal();
                    updateAttachmentImage(mediaId, response.new_media_id);
                    
                    // Auto-select the new edited image if in selector mode
                    if (window.mediaSelector && response.new_media_id) {
                        setTimeout(() => {
                            const newMediaItem = $(`.media-item[data-id="${response.new_media_id}"], .media-list-item[data-id="${response.new_media_id}"]`);
                            if (newMediaItem.length) {
                                newMediaItem.addClass('selected').find('.media-checkbox').prop('checked', true);
                                selectedItems.clear();
                                selectedItems.add(response.new_media_id);
                            }
                        }, 1000);
                    }
                }
            },
            error: function() {
                alert('Failed to save image. Please try again.');
            }
        });
    }, 'image/jpeg', 0.9);
}
</script>
