// Global media selector functionality
window.mediaSelectCallback = null;

function openMediaSelector(fieldName) {
    // Set callback for when media is selected
    window.mediaSelectCallback = function(mediaId) {
        setMediaField(fieldName, mediaId);
    };
    
    // Create and show media selector modal
    const modalHtml = `
        <div class="media-selector-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div class="media-selector-content" style="background: white; width: 90%; max-width: 1200px; height: 80%; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                
                <!-- Header -->
                <div class="media-selector-header" style="padding: 15px 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; background: #f8f9fa;">
                    <h3 style="margin: 0;">Select Media</h3>
                    <button onclick="closeMediaSelector()" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 5px;">&times;</button>
                </div>

                <!-- Filters -->
                <div class="media-selector-filters" style="padding: 10px 20px; border-bottom: 1px solid #eee; display: flex; gap: 15px; align-items: center;">
                    <input type="text" id="media-selector-search" placeholder="Search media..." style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; width: 250px;">
                    <select id="media-selector-type" style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px;">
                        <option value="all">All Types</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                        <option value="audio">Audio</option>
                        <option value="document">Documents</option>
                    </select>
                </div>

                <!-- Media Grid -->
                <div class="media-selector-body" style="flex: 1; overflow-y: auto; padding: 20px;" id="media-selector-grid">
                    <div style="text-align: center; padding: 40px; color: #666;">Loading...</div>
                </div>

                <!-- Footer -->
                <div class="media-selector-footer" style="padding: 15px 20px; border-top: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; background: #f8f9fa;">
                    <div id="selected-media-info" style="color: #666;">No media selected</div>
                    <div>
                        <button onclick="closeMediaSelector()" style="background: #666; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; margin-right: 10px;">Cancel</button>
                        <button id="select-media-btn" onclick="confirmMediaSelection()" disabled style="background: #0073aa; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">Select</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('body').append(modalHtml);
    loadMediaSelector();
}

function loadMediaSelector() {
    $.ajax({
        url: '/admin/media-library',
        data: { ajax: 1 },
        success: function(response) {
            if (response.success && response.media) {
                renderMediaGrid(response.media.data);
            }
        },
        error: function() {
            $('#media-selector-grid').html('<div style="text-align: center; padding: 40px; color: #999;">Failed to load media</div>');
        }
    });
}

function renderMediaGrid(mediaItems) {
    const grid = $('#media-selector-grid');
    let html = '<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 15px;">';
    
    mediaItems.forEach(item => {
        html += `
            <div class="media-selector-item" data-id="${item.id}" onclick="selectMediaItem(${item.id}, this)" style="border: 2px solid transparent; border-radius: 6px; overflow: hidden; cursor: pointer; transition: all 0.2s; background: white;">
                <div style="width: 100%; height: 100px; display: flex; align-items: center; justify-content: center; background: #f9f9f9;">
                    ${item.file_type === 'image' 
                        ? `<img src="${item.url}" alt="${item.title}" style="max-width: 100%; max-height: 100%; object-fit: cover;">` 
                        : `<i class="fas fa-file" style="font-size: 32px; color: #666;"></i>`
                    }
                </div>
                <div style="padding: 8px; text-align: center;">
                    <h4 style="font-size: 11px; font-weight: 500; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.title}</h4>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    grid.html(html);
}

let selectedMediaId = null;

function selectMediaItem(mediaId, element) {
    // Remove previous selection
    $('.media-selector-item').css({
        'border-color': 'transparent',
        'box-shadow': 'none'
    });
    
    // Add selection to current item
    $(element).css({
        'border-color': '#0073aa',
        'box-shadow': '0 0 0 2px rgba(0,115,170,0.3)'
    });
    
    selectedMediaId = mediaId;
    
    // Update footer info
    $('#selected-media-info').text(`Media ID: ${mediaId} selected`);
    $('#select-media-btn').prop('disabled', false);
}

function confirmMediaSelection() {
    if (selectedMediaId && window.mediaSelectCallback) {
        window.mediaSelectCallback(selectedMediaId);
        closeMediaSelector();
    }
}

function closeMediaSelector() {
    $('.media-selector-modal').remove();
    selectedMediaId = null;
}

function setMediaField(fieldName, mediaId) {
    // Set hidden input value
    $('#' + fieldName).val(mediaId);
    
    // Update preview
    $.get(`/admin/media-library/${mediaId}`, function(media) {
        const preview = $('#preview-' + fieldName);
        let previewHtml = '';
        
        if (media.file_type === 'image') {
            previewHtml = `<img src="${media.url}" alt="${media.title}" style="max-width: 200px; max-height: 100px; object-fit: cover;">`;
        } else {
            previewHtml = `
                <div style="text-align: center; color: #666;">
                    <i class="fas fa-file" style="font-size: 32px; margin-bottom: 8px;"></i>
                    <div>${media.title}</div>
                </div>
            `;
        }
        
        preview.html(previewHtml);
        
        // Add remove button if not exists
        const container = preview.closest('.media-selector-container');
        if (!container.find('.btn-secondary').length) {
            container.find('.media-actions').append(`
                <button type="button" class="btn btn-secondary" onclick="clearMedia('${fieldName}')">
                    <i class="fas fa-times"></i> Remove
                </button>
            `);
        }
    });
}

function clearMedia(fieldName) {
    // Clear hidden input
    $('#' + fieldName).val('');
    
    // Reset preview
    const preview = $('#preview-' + fieldName);
    preview.html(`
        <div style="color: #999;">
            <i class="fas fa-image" style="font-size: 32px; margin-bottom: 8px;"></i>
            <div>No media selected</div>
        </div>
    `);
    
    // Remove the remove button
    preview.closest('.media-selector-container').find('.btn-secondary').remove();
}