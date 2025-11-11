<div style="display: flex; height: 100%; min-height: 500px;">
    <div style="flex: 2; display: flex; align-items: center; justify-content: center; background: #f8f9fa; padding: 20px;">
        @if($media->isImage())
            <img id="attachment-image-{{ $media->id }}" src="{{ $media->url }}" style="max-width: 100%; max-height: 100%; object-fit: contain;" alt="{{ $media->alt_text }}">
        @elseif($media->isVideo())
            <video controls style="max-width: 100%; max-height: 100%;">
                <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                Your browser does not support the video tag.
            </video>
        @elseif($media->isAudio())
            <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                <i class="fas fa-music fa-5x" style="color: #666;"></i>
                <audio controls style="width: 300px;">
                    <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                    Your browser does not support the audio tag.
                </audio>
            </div>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; gap: 20px;">
                <i class="fas fa-file fa-5x" style="color: #666;"></i>
                <p style="font-size: 18px; margin: 0;">{{ $media->original_filename }}</p>
            </div>
        @endif
    </div>
    <div style="flex: 1; padding: 30px; background: white; overflow-y: auto;">
        <form id="media-form" data-id="{{ $media->id }}">
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Title</label>
                <input type="text" name="title" value="{{ $media->title }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Alt Text</label>
                <input type="text" name="alt_text" value="{{ $media->alt_text }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Caption</label>
                <textarea name="caption" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; height: 80px; font-size: 14px; resize: vertical;">{{ $media->caption }}</textarea>
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px;">Description</label>
                <textarea name="description" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; height: 100px; font-size: 14px; resize: vertical;">{{ $media->description }}</textarea>
            </div>
            <div style="margin-bottom: 25px; padding: 15px; background: #f8f9fa; border-radius: 4px;">
                <h4 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">File Details</h4>
                <div style="font-size: 13px; line-height: 1.5;">
                    <div><strong>Size:</strong> {{ $media->file_size_formatted }}</div>
                    <div><strong>Type:</strong> {{ $media->mime_type }}</div>
                    <div><strong>Uploaded:</strong> {{ $media->created_at->format('M d, Y g:i A') }}</div>
                    @if($media->uploader)
                        <div><strong>By:</strong> {{ $media->uploader->name }}</div>
                    @endif
                </div>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="submit" style="background: #0073aa; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">Update Media</button>
                @if($media->isImage())
                    <button type="button" onclick="editImage({{ $media->id }})" style="background: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">Edit Image</button>
                @endif
                <button type="button" onclick="deleteMedia({{ $media->id }})" style="background: #dc3232; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 500;">Delete</button>
            </div>
        </form>
    </div>
</div>
