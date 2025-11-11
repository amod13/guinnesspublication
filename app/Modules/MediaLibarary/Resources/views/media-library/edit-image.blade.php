@extends('admin.main.app')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <style>
        .image-editor {
            background: #fff;
            min-height: 100vh;
        }

        .editor-toolbar {
            background: #f1f1f1;
            border-bottom: 1px solid #ddd;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .editor-controls {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .editor-btn {
            background: #0073aa;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .editor-btn:hover {
            background: #005a87;
        }

        .editor-btn.secondary {
            background: #666;
        }

        .editor-btn.danger {
            background: #dc3232;
        }

        .editor-content {
            padding: 20px;
            display: flex;
            gap: 20px;
        }

        .image-container {
            flex: 1;
            max-height: 70vh;
            overflow: hidden;
        }

        .cropper-container {
            max-height: 100%;
        }

        .editor-sidebar {
            width: 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .control-group {
            margin-bottom: 20px;
        }

        .control-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .control-group input[type="range"] {
            width: 100%;
        }

        .preset-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 10px;
        }

        .preset-btn {
            background: #f1f1f1;
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .preset-btn:hover {
            background: #e0e0e0;
        }
    </style>

    <div class="image-editor">
        <div class="editor-toolbar">
            <div class="editor-controls">
                <button class="editor-btn" onclick="resetImage()">
                    <i class="fas fa-undo"></i> Reset
                </button>
                <button class="editor-btn" onclick="rotateLeft()">
                    <i class="fas fa-undo"></i> Rotate Left
                </button>
                <button class="editor-btn" onclick="rotateRight()">
                    <i class="fas fa-redo"></i> Rotate Right
                </button>
                <button class="editor-btn" onclick="flipHorizontal()">
                    <i class="fas fa-arrows-alt-h"></i> Flip H
                </button>
                <button class="editor-btn" onclick="flipVertical()">
                    <i class="fas fa-arrows-alt-v"></i> Flip V
                </button>
            </div>
            <div class="editor-actions">
                <button class="editor-btn secondary" onclick="cancelEdit()">Cancel</button>
                <button class="editor-btn" onclick="saveImage()">Save Changes</button>
            </div>
        </div>

        <div class="editor-content">
            <div class="image-container">
                <img id="image-editor" src="{{ $media->url }}" alt="{{ $media->title }}">
            </div>

            <div class="editor-sidebar">
                <div class="control-group">
                    <label>Crop Presets</label>
                    <div class="preset-buttons">
                        <button class="preset-btn" onclick="setCropRatio(1)">Square</button>
                        <button class="preset-btn" onclick="setCropRatio(16/9)">16:9</button>
                        <button class="preset-btn" onclick="setCropRatio(4/3)">4:3</button>
                        <button class="preset-btn" onclick="setCropRatio(3/2)">3:2</button>
                        <button class="preset-btn" onclick="setCropRatio(0)">Free</button>
                        <button class="preset-btn" onclick="setCropRatio(9/16)">9:16</button>
                    </div>
                </div>

                <div class="control-group">
                    <label for="zoom-range">Zoom: <span id="zoom-value">100%</span></label>
                    <input type="range" id="zoom-range" min="0.1" max="3" step="0.1" value="1"
                        onchange="zoomImage(this.value)">
                </div>

                <div class="control-group">
                    <label for="rotate-range">Rotate: <span id="rotate-value">0°</span></label>
                    <input type="range" id="rotate-range" min="-180" max="180" step="1" value="0"
                        onchange="rotateImage(this.value)">
                </div>

                <div class="control-group">
                    <h4>Image Info</h4>
                    <p><strong>Original:</strong> {{ $media->metadata['width'] ?? 'N/A' }} ×
                        {{ $media->metadata['height'] ?? 'N/A' }}</p>
                    <p><strong>Size:</strong> {{ $media->file_size_formatted }}</p>
                    <p><strong>Type:</strong> {{ $media->mime_type }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        let cropper;
        let originalImageData;

        document.addEventListener('DOMContentLoaded', function() {
            initializeCropper();
        });

        function initializeCropper() {
            const image = document.getElementById('image-editor');

            cropper = new Cropper(image, {
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
                toggleDragModeOnDblclick: false,
                ready: function() {
                    originalImageData = cropper.getImageData();
                }
            });
        }

        function setCropRatio(ratio) {
            if (cropper) {
                cropper.setAspectRatio(ratio);
            }
        }

        function zoomImage(value) {
            if (cropper) {
                cropper.zoomTo(value);
                document.getElementById('zoom-value').textContent = Math.round(value * 100) + '%';
            }
        }

        function rotateImage(value) {
            if (cropper) {
                cropper.rotateTo(value);
                document.getElementById('rotate-value').textContent = value + '°';
            }
        }

        function rotateLeft() {
            if (cropper) {
                cropper.rotate(-90);
                updateRotateSlider();
            }
        }

        function rotateRight() {
            if (cropper) {
                cropper.rotate(90);
                updateRotateSlider();
            }
        }

        function flipHorizontal() {
            if (cropper) {
                const imageData = cropper.getImageData();
                cropper.scaleX(imageData.scaleX === 1 ? -1 : 1);
            }
        }

        function flipVertical() {
            if (cropper) {
                const imageData = cropper.getImageData();
                cropper.scaleY(imageData.scaleY === 1 ? -1 : 1);
            }
        }

        function resetImage() {
            if (cropper) {
                cropper.reset();
                document.getElementById('zoom-range').value = 1;
                document.getElementById('rotate-range').value = 0;
                document.getElementById('zoom-value').textContent = '100%';
                document.getElementById('rotate-value').textContent = '0°';
            }
        }

        function updateRotateSlider() {
            if (cropper) {
                const imageData = cropper.getImageData();
                document.getElementById('rotate-range').value = imageData.rotate;
                document.getElementById('rotate-value').textContent = imageData.rotate + '°';
            }
        }

        function cancelEdit() {
            window.location.href = '{{ route('media-library.index') }}';
        }

        function saveImage() {
            if (!cropper) {
                alert('Image editor not ready. Please wait.');
                return;
            }

            const canvas = cropper.getCroppedCanvas({
                maxWidth: 2000,
                maxHeight: 2000,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            canvas.toBlob(function(blob) {
                const formData = new FormData();
                formData.append('image', blob, '{{ $media->filename }}');

                $.ajax({
                    url: '{{ route('media-library.save-image', $media->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Image saved successfully!');
                            window.location.href = '{{ route('media-library.index') }}';
                        }
                    },
                    error: function() {
                        alert('Failed to save image. Please try again.');
                    }
                });
            }, 'image/jpeg', 0.9);
        }
    </script>
@endpush
