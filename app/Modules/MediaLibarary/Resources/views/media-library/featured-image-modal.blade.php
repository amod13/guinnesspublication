<style>
    .featured-media-item {
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .featured-media-item:hover {
        border-color: #0073aa;
        box-shadow: 0 2px 8px rgba(0, 115, 170, 0.15);
        transform: translateY(-1px);
    }

    .featured-media-item.selected {
        border-color: #0073aa;
        box-shadow: 0 0 0 3px rgba(0, 115, 170, 0.2), 0 2px 8px rgba(0, 115, 170, 0.15);
        transform: translateY(-1px);
    }

    .featured-media-thumbnail {
        width: 100%;
        height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-bottom: 1px solid #e1e5e9;
    }

    .featured-media-thumbnail img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .featured-media-info {
        padding: 12px 8px;
        background: white;
        font-size: 13px;
        text-align: center;
        font-weight: 500;
        color: #23282d;
        line-height: 1.3;
    }

    .upload-drop-area.dragover {
        border-color: #0073aa;
        background: #f0f6fc;
        transform: scale(1.02);
    }

    .tab-btn:hover {
        color: #0073aa !important;
        background: rgba(0, 115, 170, 0.05) !important;
    }
</style>
<!-- Featured Image Modal -->
<div id="featured-image-modal" class="modal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; backdrop-filter: blur(2px);">
    <div class="modal-content"
        style="background: white; width: 100%; height: 100%; display: flex; flex-direction: column; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div class="modal-header"
            style="padding: 20px 30px; border-bottom: 1px solid #e1e5e9; background: #fff; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin: 0; font-size: 20px; font-weight: 600; color: #23282d;">Set Featured Image</h3>
            <button type="button" class="modal-close" onclick="closeFeaturedImageModal()"
                style="background: none; border: none; font-size: 28px; cursor: pointer; color: #666; padding: 5px; border-radius: 3px; transition: all 0.2s;"
                onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='none'">&times;</button>
        </div>
        <div class="modal-body" style="flex: 1; display: flex;">
            <!-- Left Side: Media Library & Upload -->
            <div class="media-section" style="flex: 2; display: flex; flex-direction: column;">
                <!-- Tabs -->
                <div class="media-tabs" style="display: flex; border-bottom: 1px solid #e1e5e9; background: #f9f9f9;">
                    <button type="button" class="tab-btn active" onclick="switchFeaturedTab('library')"
                        style="background: none; border: none; padding: 16px 24px; cursor: pointer; border-bottom: 3px solid #0073aa; font-weight: 600; color: #0073aa; font-size: 14px; transition: all 0.2s;">Media
                        Library</button>
                    <button type="button" class="tab-btn" onclick="switchFeaturedTab('upload')"
                        style="background: none; border: none; padding: 16px 24px; cursor: pointer; border-bottom: 3px solid transparent; font-weight: 600; color: #666; font-size: 14px; transition: all 0.2s;">Upload
                        Files</button>
                </div>

                <!-- Media Library Tab -->
                <div id="library-featured-tab" class="tab-content active"
                    style="flex: 1; padding: 24px; overflow-y: auto; background: #fff;">
                    <div class="search-filter" style="margin-bottom: 24px; display: flex; gap: 12px;">
                        <input type="text" id="featured-search" placeholder="Search media..."
                            style="flex: 1; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; transition: border-color 0.2s;"
                            onfocus="this.style.borderColor='#0073aa'" onblur="this.style.borderColor='#ddd'">
                        <select id="featured-type-filter"
                            style="padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white; cursor: pointer;">
                            <option value="all">All media items</option>
                            <option value="image">Images</option>
                            <option value="video">Videos</option>
                            <option value="audio">Audio</option>
                            <option value="document">Documents</option>
                        </select>
                    </div>
                    <div id="featured-media-grid"
                        style="display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; max-height: calc(100vh - 300px); overflow-y: auto; padding-right: 8px;">
                    </div>
                </div>

                <!-- Upload Tab -->
                <div id="upload-featured-tab" class="tab-content" style="display: none; flex: 1; padding: 20px;">
                    <div class="upload-drop-area" id="featured-upload-area"
                        style="height: 100%; display: flex; flex-direction: row; align-items: center; justify-content: center; border: 2px dashed #ddd; border-radius: 8px; text-align: center;">
                        <i class="fas fa-cloud-upload-alt fa-4x" style="color: #666; margin-bottom: 20px;"></i>
                        <h3>Drop files to upload</h3>
                        <p>or <button type="button" class="select-files-btn"
                                onclick="document.getElementById('featured-file-input').click()"
                                style="background: #0073aa; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">select
                                files</button></p>
                        <input type="file" id="featured-file-input" multiple
                            accept="image/*,video/*,audio/*,.pdf,.doc,.docx" style="display: none;">
                    </div>
                </div>
            </div>

            <!-- Right Side: Attachment Details -->
            <div class="attachment-details"
                style="flex: 1; border-left: 1px solid #e1e5e9; background: #f8f9fa; display: flex; flex-direction: column;">
                <div id="attachment-details-content"
                    style="flex: 1; padding: 24px; overflow-y: auto; background: #fff; margin: 0;">
                    <div class="no-selection" style="text-align: center; color: #666; padding: 60px 20px;">
                        <i class="fas fa-image fa-4x" style="margin-bottom: 24px; opacity: 0.3; color: #ccc;"></i>
                        <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 500;">No media selected</h4>
                        <p style="margin: 0; font-size: 14px; color: #999;">Select an attachment to view details</p>
                    </div>
                </div>
                <div class="attachment-actions"
                    style="padding: 24px; border-top: 1px solid #e1e5e9; background: white;">
                    <button type="button" id="set-featured-btn" onclick="setFeaturedImage()" disabled
                        style="background: #e0e0e0; color: #999; border: none; padding: 14px 24px; border-radius: 6px; cursor: not-allowed; width: 100%; font-weight: 600; font-size: 14px; transition: all 0.2s;">Set
                        Featured Image</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery for AJAX functionality -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include CropperJS for image editing -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    let currentFeaturedInputId = null;
    let selectedFeaturedMediaId = null;
    let featuredMediaList = [];
    let currentPage = 1;
    let hasMorePages = true;
    let isLoading = false;

    // Image editor functions for featured image modal
    function openEditImageModal(id) {
        console.log('Opening edit image modal for ID:', id);

        // Load image edit interface in modal using jQuery AJAX
        $.ajax({
            url: '{{ route('media-library.edit-image', ':id') }}'.replace(':id', id),
            success: function(html) {
                console.log('Edit image modal content loaded successfully');

                // Create modal if it doesn't exist
                let modal = document.getElementById('image-edit-modal');
                if (!modal) {
                    console.log('Creating new edit image modal');
                    const modalHtml = `
                    <div id="image-edit-modal" class="modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 2000;">
                        <div class="modal-content" style="background: white; width: 90%; height: 90%; margin: 2.5% auto; display: flex; flex-direction: column; border-radius: 8px; overflow: hidden;">
                            <div class="modal-header" style="padding: 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
                                <h3 style="margin: 0;">Edit Image</h3>
                                <button class="modal-close" onclick="closeImageEditModal()" style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                            </div>
                            <div class="modal-body" id="image-edit-content" style="padding: 20px; flex: 1; overflow-y: auto;"></div>
                        </div>
                    </div>
                `;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    modal = document.getElementById('image-edit-modal');
                }

                document.getElementById('image-edit-content').innerHTML = html;
                modal.style.display = 'block';
                window.currentMediaId = id;

                console.log('Edit image modal displayed, currentMediaId set to:', id);

                // Execute scripts in the loaded content
                const scripts = modal.querySelectorAll('script');
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    if (script.src) {
                        newScript.src = script.src;
                    } else {
                        newScript.textContent = script.textContent;
                    }
                    document.head.appendChild(newScript);
                    document.head.removeChild(newScript);
                });

                // Initialize CropperJS manually if not initialized
                setTimeout(() => {
                    console.log('Checking CropperJS availability...');
                    console.log('window.modalCropper:', window.modalCropper);
                    console.log('typeof Cropper:', typeof Cropper);

                    const imageElement = document.getElementById('modal-image-editor');
                    console.log('Image element found:', imageElement);

                    if (imageElement && typeof Cropper !== 'undefined') {
                        if (!window.modalCropper) {
                            console.log('Manually initializing CropperJS...');
                            window.modalCropper = new Cropper(imageElement, {
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
                            console.log('CropperJS manually initialized');
                        } else {
                            console.log('CropperJS already initialized');
                        }
                    } else {
                        console.error('CropperJS not available or image element not found');
                    }
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error('Failed to load image editor:', error);
                alert('Failed to load image editor');
            }
        });
    }

    function closeImageEditModal() {
        if (window.modalCropper) {
            window.modalCropper.destroy();
            window.modalCropper = null;
        }
        const modal = document.getElementById('image-edit-modal');
        if (modal) {
            modal.style.display = 'none';
            const content = document.getElementById('image-edit-content');
            if (content) {
                content.innerHTML = '';
            }
        }
    }

    // Modal crop functions
    function modalSetCropRatio(ratio) {
        console.log('modalSetCropRatio called with ratio:', ratio);
        console.log('window.modalCropper:', window.modalCropper);

        if (window.modalCropper) {
            window.modalCropper.setAspectRatio(ratio);
            console.log('Crop ratio set to:', ratio);
        } else {
            console.error('modalCropper not available');
            alert('Image editor not ready. Please wait a moment and try again.');
        }
    }

    function modalZoomImage(value) {
        if (window.modalCropper) {
            window.modalCropper.zoomTo(value);
            const zoomValue = document.getElementById('modal-zoom-value');
            if (zoomValue) zoomValue.textContent = Math.round(value * 100) + '%';
        }
    }

    function modalRotateImage(value) {
        if (window.modalCropper) {
            window.modalCropper.rotateTo(value);
            const rotateValue = document.getElementById('modal-rotate-value');
            if (rotateValue) rotateValue.textContent = value + '°';
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
            const zoomRange = document.getElementById('modal-zoom-range');
            const rotateRange = document.getElementById('modal-rotate-range');
            const zoomValue = document.getElementById('modal-zoom-value');
            const rotateValue = document.getElementById('modal-rotate-value');

            if (zoomRange) zoomRange.value = 1;
            if (rotateRange) rotateRange.value = 0;
            if (zoomValue) zoomValue.textContent = '100%';
            if (rotateValue) rotateValue.textContent = '0°';
        }
    }

    function updateModalRotateSlider() {
        if (window.modalCropper) {
            const imageData = window.modalCropper.getImageData();
            const rotateRange = document.getElementById('modal-rotate-range');
            const rotateValue = document.getElementById('modal-rotate-value');

            if (rotateRange) rotateRange.value = imageData.rotate;
            if (rotateValue) rotateValue.textContent = imageData.rotate + '°';
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
                url: '{{ route('media-library.save-image', ':id') }}'.replace(':id', mediaId),
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
                        closeImageEditModal();
                        updateAttachmentImage(mediaId);
                    }
                },
                error: function() {
                    alert('Failed to save image. Please try again.');
                }
            });
        }, 'image/jpeg', 0.9);
    }

    function openFeaturedImageModal(inputId) {
        currentFeaturedInputId = inputId;
        document.getElementById('featured-image-modal').style.display = 'block';
        loadFeaturedMedia();
        initializeFeaturedUpload();
        initializeInfiniteScroll();
    }

    function closeFeaturedImageModal() {
        document.getElementById('featured-image-modal').style.display = 'none';
        currentFeaturedInputId = null;
        selectedFeaturedMediaId = null;
        resetAttachmentDetails();
    }

    function switchFeaturedTab(tab) {
        // Unselect any selected media when switching tabs
        selectedFeaturedMediaId = null;
        document.querySelectorAll('.featured-media-item').forEach(item => {
            item.classList.remove('selected');
        });
        resetAttachmentDetails();

        // Reset all tabs
        document.querySelectorAll('#featured-image-modal .tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.borderBottomColor = 'transparent';
            btn.style.color = '#666';
        });
        document.querySelectorAll('#featured-image-modal .tab-content').forEach(content => {
            content.style.display = 'none';
        });

        if (tab === 'library') {
            const libraryBtn = document.querySelector('#featured-image-modal .tab-btn:first-child');
            libraryBtn.classList.add('active');
            libraryBtn.style.borderBottomColor = '#0073aa';
            libraryBtn.style.color = '#0073aa';
            document.getElementById('library-featured-tab').style.display = 'block';
            // Reload media when switching back to library tab
            loadFeaturedMedia();
        } else {
            const uploadBtn = document.querySelector('#featured-image-modal .tab-btn:last-child');
            uploadBtn.classList.add('active');
            uploadBtn.style.borderBottomColor = '#0073aa';
            uploadBtn.style.color = '#0073aa';
            document.getElementById('upload-featured-tab').style.display = 'flex';
        }
    }

    function loadFeaturedMedia(reset = true) {
        if (isLoading) return;

        if (reset) {
            currentPage = 1;
            hasMorePages = true;
            featuredMediaList = [];
        }

        if (!hasMorePages) return;

        isLoading = true;
        const search = document.getElementById('featured-search').value || '';
        const type = document.getElementById('featured-type-filter').value || 'all';

        fetch(`{{ route('media-library.index') }}?selector=true&search=${search}&type=${type}&page=${currentPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.media && data.media.data) {
                    if (reset) {
                        featuredMediaList = data.media.data;
                    } else {
                        featuredMediaList = [...featuredMediaList, ...data.media.data];
                    }

                    hasMorePages = data.media.current_page < data.media.last_page;
                    currentPage++;

                    renderFeaturedMedia(featuredMediaList, reset);
                } else {
                    if (reset) {
                        document.getElementById('featured-media-grid').innerHTML =
                            '<p style="text-align: center; color: #666; padding: 40px;">No media found</p>';
                    }
                }
            })
            .catch(error => {
                console.error('Error loading media:', error);
                if (reset) {
                    document.getElementById('featured-media-grid').innerHTML =
                        '<p style="text-align: center; color: #666; padding: 40px;">Error loading media</p>';
                }
            })
            .finally(() => {
                isLoading = false;
            });
    }

    function renderFeaturedMedia(mediaItems, reset = true) {
        const grid = document.getElementById('featured-media-grid');

        if (!mediaItems || mediaItems.length === 0) {
            if (reset) {
                grid.innerHTML = '<p style="text-align: center; color: #666; padding: 40px;">No media items found</p>';
            }
            return;
        }

        let html = '';
        mediaItems.forEach(item => {
            const thumbnail = item.file_type === 'image' ?
                `<img src="${item.url}" alt="${item.title}">` :
                `<i class="fas fa-file fa-3x" style="color: #666;"></i>`;

            html += `
            <div class="featured-media-item" onclick="selectFeaturedMediaItem(${item.id})" data-id="${item.id}">
                <div class="featured-media-thumbnail">${thumbnail}</div>
                <div class="featured-media-info">${item.title}</div>
            </div>
        `;
        });

        if (reset) {
            grid.innerHTML = html;
        } else {
            grid.innerHTML += html;
        }

        // Add loading indicator if there are more pages
        if (hasMorePages && !isLoading) {
            grid.innerHTML +=
                '<div id="loading-indicator" style="text-align: center; padding: 20px; color: #666;">Scroll down to load more...</div>';
        }
    }

    function selectFeaturedMediaItem(id) {
        document.querySelectorAll('.featured-media-item').forEach(item => {
            item.classList.remove('selected');
        });

        const selectedItem = document.querySelector(`[data-id="${id}"]`);
        selectedItem.classList.add('selected');

        selectedFeaturedMediaId = id;
        loadAttachmentDetails(id);

        const btn = document.getElementById('set-featured-btn');
        btn.disabled = false;
        btn.style.background = '#0073aa';
        btn.style.color = 'white';
        btn.style.cursor = 'pointer';
    }

    function loadAttachmentDetails(id) {
        const selectedMedia = featuredMediaList.find(item => item.id === id);
        if (!selectedMedia) return;

        const detailsContent = document.getElementById('attachment-details-content');

        const isImage = selectedMedia.file_type === 'image';
        const preview = isImage ?
            `<img src="${selectedMedia.url}" style="max-width: 100%; height: auto; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">` :
            `<div style="padding: 40px; text-align: center; background: #f8f9fa; border-radius: 6px;"><i class="fas fa-file fa-3x" style="color: #666;"></i></div>`;

        const uploadDate = new Date(selectedMedia.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        detailsContent.innerHTML = `
        <div style="margin-bottom: 20px;">
            ${preview}
        </div>

        <div style="margin-bottom: 20px;">
            <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600; color: #23282d;">${selectedMedia.original_filename || selectedMedia.title}</h4>
            <p style="margin: 0 0 4px 0; font-size: 13px; color: #666;">${uploadDate}</p>
            <p style="margin: 0 0 4px 0; font-size: 13px; color: #666;">${selectedMedia.file_size_formatted || 'Unknown size'}</p>
            ${selectedMedia.metadata && selectedMedia.metadata.width ?
                `<p style="margin: 0 0 4px 0; font-size: 13px; color: #666;">${selectedMedia.metadata.width} by ${selectedMedia.metadata.height} pixels</p>` : ''}
            <p style="margin: 0 0 16px 0; font-size: 13px; color: #666;">Original image: ${selectedMedia.original_filename}</p>

            <div style="margin-bottom: 16px;">
                ${isImage ? `<button type="button" onclick="openEditImageModal(${selectedMedia.id})" style="background: #0073aa; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; margin-right: 8px;">Edit Image</button>` : ''}
                <button type="button" onclick="deleteFeaturedMedia(${selectedMedia.id})" style="background: #dc3232; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 12px;">Delete permanently</button>
            </div>
        </div>

        <div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-size: 13px; font-weight: 500;">Title</label>
                <input type="text" id="media-title-${selectedMedia.id}" value="${selectedMedia.title}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-size: 13px; font-weight: 500;">Alt Text</label>
                <input type="text" id="media-alt-${selectedMedia.id}" value="${selectedMedia.alt_text || ''}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-size: 13px; font-weight: 500;">Caption</label>
                <textarea id="media-caption-${selectedMedia.id}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; height: 60px; resize: vertical;">${selectedMedia.caption || ''}</textarea>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; margin-bottom: 4px; font-size: 13px; font-weight: 500;">Description</label>
                <textarea id="media-description-${selectedMedia.id}" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; height: 80px; resize: vertical;">${selectedMedia.description || ''}</textarea>
            </div>

            <button type="button" onclick="updateFeaturedMedia(${selectedMedia.id})" style="background: #0073aa; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 13px; width: 100%;">Update</button>
        </div>
    `;
    }

    function resetAttachmentDetails() {
        document.getElementById('attachment-details-content').innerHTML = `
        <div class="no-selection" style="text-align: center; color: #666; padding: 40px 20px;">
            <i class="fas fa-image fa-3x" style="margin-bottom: 20px; opacity: 0.5;"></i>
            <p>Select an attachment to view details</p>
        </div>
    `;
        const btn = document.getElementById('set-featured-btn');
        btn.disabled = true;
        btn.style.background = '#e0e0e0';
        btn.style.color = '#999';
        btn.style.cursor = 'not-allowed';
    }

    function setFeaturedImage() {
        if (selectedFeaturedMediaId && currentFeaturedInputId) {
            const selectedMedia = featuredMediaList.find(item => item.id === selectedFeaturedMediaId);
            if (selectedMedia) {
                // Store media ID (WordPress style)
                document.getElementById(currentFeaturedInputId + '_media_id').value = selectedMedia.id;
                // Keep URL for preview
                document.getElementById(currentFeaturedInputId + '_url').value = selectedMedia.url;

                // Update preview
                const preview = document.getElementById(currentFeaturedInputId + '_preview');
                const uploadPlaceholder = document.querySelector(`[onclick*="${currentFeaturedInputId}"] .upload-placeholder`);
                const deleteBtn = document.querySelector(`[onclick*="${currentFeaturedInputId}"] .delete-btn`);
                
                if (preview) {
                    if (selectedMedia.file_type === 'image') {
                        preview.innerHTML =
                            `<img src="${selectedMedia.url}" class="preview-img preview-in-field-${currentFeaturedInputId}" style="max-width: 100%; max-height: 100%; display: block;">`;
                    } else {
                        preview.innerHTML = `<div style="padding: 20px; background: #f9f9f9; border-radius: 4px; text-align: center;">
                        <i class="fas fa-file fa-2x" style="color: #666;"></i>
                        <p style="margin: 10px 0 0 0; font-size: 12px;">${selectedMedia.title}</p>
                    </div>`;
                    }
                }
                
                // Hide placeholder and show delete button
                if (uploadPlaceholder) uploadPlaceholder.style.display = 'none';
                if (deleteBtn) deleteBtn.style.display = 'block';

                closeFeaturedImageModal();
            }
        }
    }

    function initializeFeaturedUpload() {
        const uploadArea = document.getElementById('featured-upload-area');
        const fileInput = document.getElementById('featured-file-input');

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
            uploadFeaturedFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', (e) => {
            uploadFeaturedFiles(e.target.files);
        });
    }

    function uploadFeaturedFiles(files) {
        if (files.length === 0) return;

        const formData = new FormData();
        for (let file of files) {
            formData.append('files[]', file);
        }

        const uploadArea = document.getElementById('featured-upload-area');
        const originalContent = uploadArea.innerHTML;
        uploadArea.innerHTML = '<h3>Uploading...</h3><p>Please wait...</p>';

        fetch('{{ route('media-library.upload') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                uploadArea.innerHTML = originalContent;
                if (data.success) {
                    switchFeaturedTab('library');
                    loadFeaturedMedia();

                    // Auto-select the first uploaded image if only one file was uploaded
                    if (files.length === 1 && data.media && data.media.length > 0) {
                        setTimeout(() => {
                            const uploadedMediaId = data.media[0].id;
                            selectFeaturedMediaItem(uploadedMediaId);
                        }, 500); // Small delay to ensure media is rendered
                    }
                } else {
                    alert('Upload failed: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                uploadArea.innerHTML = originalContent;
                console.error('Upload error:', error);
                alert('Upload failed. Please try again.');
            });
    }





    function updateAttachmentImage(mediaId) {
        // Refresh featured media list after image update with cache busting
        loadFeaturedMedia(true);

        // Update attachment details if the same media is selected
        if (selectedFeaturedMediaId === mediaId) {
            // Wait for media list to refresh then update details
            setTimeout(() => {
                const updatedMedia = featuredMediaList.find(item => item.id === mediaId);
                if (updatedMedia) {
                    // Force refresh the attachment details with cache busting
                    loadAttachmentDetails(mediaId);
                }
            }, 1000);
        }
    }



    function deleteFeaturedMedia(id) {
        if (confirm('Are you sure you want to delete this media permanently?')) {
            fetch(`{{ route('media-library.destroy', ':id') }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadFeaturedMedia();
                        resetAttachmentDetails();
                    } else {
                        alert('Failed to delete media');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete media');
                });
        }
    }

    function updateFeaturedMedia(id) {
        const title = document.getElementById(`media-title-${id}`).value;
        const altText = document.getElementById(`media-alt-${id}`).value;
        const caption = document.getElementById(`media-caption-${id}`).value;
        const description = document.getElementById(`media-description-${id}`).value;

        fetch(`{{ route('media-library.update', ':id') }}`.replace(':id', id), {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    title: title,
                    alt_text: altText,
                    caption: caption,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Media updated successfully');
                    loadFeaturedMedia();
                } else {
                    alert('Failed to update media');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update media');
            });
    }

    function initializeInfiniteScroll() {
        const scrollContainer = document.getElementById('featured-media-grid');

        console.log('Initializing infinite scroll on:', scrollContainer);

        scrollContainer.addEventListener('scroll', function() {
            console.log('Scroll detected - isLoading:', isLoading, 'hasMorePages:', hasMorePages);

            if (isLoading || !hasMorePages) return;

            const scrollTop = scrollContainer.scrollTop;
            const scrollHeight = scrollContainer.scrollHeight;
            const clientHeight = scrollContainer.clientHeight;

            console.log('Scroll position:', scrollTop + clientHeight, 'of', scrollHeight);

            // Load more when user scrolls to 80% of the content
            if (scrollTop + clientHeight >= scrollHeight * 0.8) {
                console.log('Loading more media...');
                loadFeaturedMedia(false);
            }
        });
    }

    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout;

        document.addEventListener('input', function(e) {
            if (e.target.id === 'featured-search') {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    loadFeaturedMedia(true);
                }, 500);
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.id === 'featured-type-filter') {
                loadFeaturedMedia(true);
            }
        });
    });
</script>
