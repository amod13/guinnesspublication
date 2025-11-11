<div class="media-selector-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; align-items: center; justify-content: center;">
    <div class="media-selector-content" style="background: white; width: 90%; max-width: 1200px; height: 80%; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
        
        <!-- Header -->
        <div class="media-selector-header" style="padding: 15px 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; background: #f8f9fa;">
            <h3 style="margin: 0;">Select Media</h3>
            <div style="display: flex; gap: 10px; align-items: center;">
                <button class="media-selector-btn" onclick="openMediaUpload()" style="background: #0073aa; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                    <i class="fas fa-upload"></i> Upload New
                </button>
                <button onclick="closeMediaSelector()" style="background: none; border: none; font-size: 24px; cursor: pointer; padding: 5px;">&times;</button>
            </div>
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
            <!-- Media items will be loaded here -->
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

<style>
.media-selector-item {
    border: 2px solid transparent;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.2s;
    background: white;
}

.media-selector-item:hover {
    border-color: #0073aa;
    box-shadow: 0 2px 8px rgba(0,115,170,0.2);
}

.media-selector-item.selected {
    border-color: #0073aa;
    box-shadow: 0 0 0 2px rgba(0,115,170,0.3);
}

.media-selector-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
}

.media-selector-thumbnail {
    width: 100%;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
}

.media-selector-thumbnail img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

.media-selector-info {
    padding: 8px;
    text-align: center;
}

.media-selector-title {
    font-size: 11px;
    font-weight: 500;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<script>
let selectedMediaId = null;
let selectedMediaData = null;

function loadMediaSelector() {
    $.ajax({
        url: '{{ route("media-library.index") }}',
        data: { ajax: 1 },
        success: function(response) {
            if (response.success) {
                renderMediaGrid(response.media.data);
            }
        }
    });
}

function renderMediaGrid(mediaItems) {
    const grid = $('#media-selector-grid');
    let html = '<div class="media-selector-grid">';
    
    mediaItems.forEach(item => {
        html += `
            <div class="media-selector-item" data-id="${item.id}" onclick="selectMediaItem(${item.id}, this)">
                <div class="media-selector-thumbnail">
                    ${item.file_type === 'image' 
                        ? `<img src="${item.url}" alt="${item.title}">` 
                        : `<i class="fas fa-file file-icon" style="font-size: 32px; color: #666;"></i>`
                    }
                </div>
                <div class="media-selector-info">
                    <h4 class="media-selector-title">${item.title}</h4>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    grid.html(html);
}

function selectMediaItem(mediaId, element) {
    // Remove previous selection
    $('.media-selector-item').removeClass('selected');
    
    // Add selection to current item
    $(element).addClass('selected');
    
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
    selectedMediaData = null;
}

function openMediaUpload() {
    // You can implement upload functionality here
    alert('Upload functionality can be added here');
}

// Initialize when modal opens
$(document).ready(function() {
    loadMediaSelector();
});
</script>