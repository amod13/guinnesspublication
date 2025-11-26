@extends('admin.main.app')
@section('content')

<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --success-color: #10b981;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
    }

    .settings-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .settings-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 1.5rem;
        padding: 3rem 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.3);
        position: relative;
        overflow: hidden;
    }

    .settings-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.2); opacity: 0.3; }
    }

    .settings-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        position: relative;
        z-index: 1;
    }

    .settings-header p {
        font-size: 1.125rem;
        opacity: 0.95;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .modern-tabs {
        background: white;
        border-radius: 1.25rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .tab-btn {
        flex: 1;
        min-width: 200px;
        padding: 1.25rem 1.5rem;
        border: 2px solid var(--gray-200);
        border-radius: 1rem;
        background: white;
        color: var(--gray-600);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
    }

    .tab-btn i {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .tab-btn:hover {
        border-color: var(--primary-light);
        background: var(--gray-50);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.2);
    }

    .tab-btn:hover i {
        transform: scale(1.1);
    }

    .tab-btn.active {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.5);
    }

    .tab-btn.active::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 100%);
    }

    .settings-content {
        background: white;
        border-radius: 1.5rem;
        padding: 2.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
    }

    .tab-content-panel {
        display: none;
        animation: fadeIn 0.4s ease-in-out;
    }

    .tab-content-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        font-size: 2rem;
        color: var(--primary-color);
    }

    .section-subtitle {
        color: var(--gray-500);
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.75rem;
        margin-bottom: 2rem;
    }

    .form-group-modern {
        position: relative;
    }

    .form-group-modern label {
        display: block;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group-modern label i {
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .form-input-modern {
        width: 100%;
        padding: 0.95rem 1.25rem;
        border: 2px solid var(--gray-200);
        border-radius: 0.875rem;
        font-size: 1rem;
        color: var(--gray-800);
        transition: all 0.2s ease;
        background: var(--gray-50);
    }

    .form-input-modern:focus {
        outline: none;
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .form-input-modern::placeholder {
        color: var(--gray-400);
    }

    textarea.form-input-modern {
        resize: vertical;
        min-height: 120px;
    }

    .image-upload-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .image-upload-card {
        background: linear-gradient(145deg, var(--gray-50) 0%, white 100%);
        border: 2px solid var(--gray-200);
        border-radius: 1.25rem;
        padding: 1.75rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .image-upload-card:hover {
        border-color: var(--primary-color);
        box-shadow: 0 15px 30px -10px rgba(99, 102, 241, 0.3);
        transform: translateY(-5px);
    }

    .image-upload-card h6 {
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .image-upload-card h6 i {
        color: var(--primary-color);
    }

    .image-upload-card .badge {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
        background: var(--gray-200);
        color: var(--gray-600);
        margin-bottom: 1rem;
        display: inline-block;
    }

    .image-preview-modern {
        border: 3px dashed var(--gray-300);
        border-radius: 1rem;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 1.5rem;
        background: white;
        transition: all 0.3s ease;
        position: relative;
    }

    .image-upload-card:hover .image-preview-modern {
        border-color: var(--primary-light);
        background: var(--gray-50);
    }

    .image-preview-modern img {
        max-height: 180px;
        max-width: 100%;
        object-fit: contain;
        border-radius: 0.5rem;
    }

    .image-placeholder {
        text-align: center;
        color: var(--gray-400);
    }

    .image-placeholder i {
        font-size: 3rem;
        margin-bottom: 0.75rem;
        color: var(--gray-300);
    }

    .custom-file-input {
        margin-top: 1rem;
        position: relative;
    }

    .custom-file-input input[type="file"] {
        display: none;
    }

    .file-input-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--primary-color);
        color: white;
        border-radius: 0.75rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        font-size: 0.95rem;
    }

    .file-input-label:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px -5px rgba(99, 102, 241, 0.5);
    }

    .save-button-container {
        position: sticky;
        bottom: 2rem;
        z-index: 100;
        padding-top: 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .btn-modern {
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 10px 25px -10px rgba(99, 102, 241, 0.6);
    }

    .btn-primary-modern::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-primary-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px -10px rgba(99, 102, 241, 0.7);
    }

    .btn-primary-modern:hover::before {
        opacity: 1;
    }

    .btn-primary-modern i {
        font-size: 1.3rem;
    }

    @media (max-width: 768px) {
        .settings-header {
            padding: 2rem 1.5rem;
        }

        .settings-header h1 {
            font-size: 1.75rem;
        }

        .modern-tabs {
            padding: 1rem;
        }

        .tab-btn {
            min-width: 100%;
        }

        .settings-content {
            padding: 1.5rem;
        }

        .form-grid,
        .image-upload-container {
            grid-template-columns: 1fr;
        }
    }

    /* Enhanced Input Icons */
    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
        font-size: 1.2rem;
        pointer-events: none;
    }

    .input-with-icon .form-input-modern {
        padding-left: 3rem;
    }

    /* Success badge for uploaded images */
    .upload-success {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--success-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.85rem;
        font-weight: 600;
        display: none;
    }

    .has-image .upload-success {
        display: block;
    }

    /* Map Preview Styles */
    .map-preview-container {
        margin-top: 1.5rem;
        border: 2px solid var(--gray-200);
        border-radius: 1rem;
        padding: 1.5rem;
        background: white;
        animation: fadeIn 0.4s ease-in-out;
    }

    .map-preview-label {
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.05rem;
    }

    .map-preview-label i {
        color: var(--primary-color);
        font-size: 1.2rem;
    }

    .map-preview-wrapper {
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        background: var(--gray-100);
        min-height: 400px;
    }

    .map-preview-wrapper iframe {
        width: 100%;
        height: 450px;
        border: none;
        display: block;
    }
</style>

<div class="settings-container">
    <!-- Modern Header -->
    <div class="settings-header">
        <h1><i class="ri-settings-3-line"></i> Website Configuration</h1>
        <p>Manage your site's core settings, social links, and branding assets with ease</p>
    </div>

    <form action="{{ route('setting.update', $data['setting']->id ?? 0) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Modern Tabs -->
        <div class="modern-tabs">
            <button type="button" class="tab-btn active" data-tab="general">
                <i class="ri-settings-4-line"></i>
                <span>General Settings</span>
            </button>
            <button type="button" class="tab-btn" data-tab="social">
                <i class="ri-share-circle-line"></i>
                <span>Social Media</span>
            </button>
            <button type="button" class="tab-btn" data-tab="branding">
                <i class="ri-brush-3-line"></i>
                <span>Branding</span>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="settings-content">
            <!-- General Settings Panel -->
            <div class="tab-content-panel active" id="general">
                <div class="section-title">
                    <i class="ri-information-line"></i>
                    General Information
                </div>
                <p class="section-subtitle">Configure your website's basic information and contact details</p>

                <div class="form-grid">
                    <div class="form-group-modern">
                        <label for="site_name">
                            <i class="ri-global-line"></i>
                            Site Name
                        </label>
                        <input type="text" id="site_name" name="site_name" 
                               class="form-input-modern" 
                               value="{{ old('site_name', $data['setting']->site_name ?? '') }}"
                               placeholder="Enter your site name">
                    </div>

                    <div class="form-group-modern">
                        <label for="email">
                            <i class="ri-mail-line"></i>
                            Contact Email
                        </label>
                        <input type="email" id="email" name="email" 
                               class="form-input-modern" 
                               value="{{ old('email', $data['global_setting']->email ?? '') }}"
                               placeholder="contact@yoursite.com">
                    </div>

                    <div class="form-group-modern">
                        <label for="phone">
                            <i class="ri-phone-line"></i>
                            Phone Number
                        </label>
                        <input type="text" id="phone" name="phone" 
                               class="form-input-modern" 
                               value="{{ old('phone', $data['setting']->phone ?? '') }}"
                               placeholder="+1 (234) 567-8900">
                    </div>

                    <div class="form-group-modern">
                        <label for="helpline">
                            <i class="ri-customer-service-2-line"></i>
                            Helpline Number
                        </label>
                        <input type="text" id="helpline" name="helpline" 
                               class="form-input-modern" 
                               value="{{ old('helpline', $data['setting']->helpline ?? '') }}"
                               placeholder="+1 (234) 567-8901">
                    </div>

                    <div class="form-group-modern">
                        <label for="address">
                            <i class="ri-map-pin-line"></i>
                            Physical Address
                        </label>
                        <input type="text" id="address" name="address" 
                               class="form-input-modern" 
                               value="{{ old('address', $data['setting']->address ?? '') }}"
                               placeholder="123 Main Street, City, Country">
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="google_map">
                        <i class="ri-map-2-line"></i>
                        Google Map Embed Code
                    </label>
                    <textarea id="google_map" name="google_map" 
                              class="form-input-modern" 
                              placeholder="Paste your Google Map embed code here">{{ old('google_map', $data['global_setting']->google_map ?? '') }}</textarea>
                    
                    <!-- Map Preview -->
                    <div class="map-preview-container" id="mapPreviewContainer" style="display: {{ !empty($data['global_setting']->google_map ?? '') ? 'block' : 'none' }};">
                        <div class="map-preview-label">
                            <i class="ri-map-pin-line"></i> Map Preview
                        </div>
                        <div class="map-preview-wrapper" id="mapPreviewWrapper">
                            @if (!empty($data['global_setting']->google_map ?? ''))
                                {!! $data['global_setting']->google_map !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Panel -->
            <div class="tab-content-panel" id="social">
                <div class="section-title">
                    <i class="ri-links-line"></i>
                    Social Media Links
                </div>
                <p class="section-subtitle">Connect your social media profiles with full URLs</p>

                <div class="form-grid">
                    <div class="form-group-modern">
                        <label for="facebook">
                            <i class="ri-facebook-fill"></i>
                            Facebook URL
                        </label>
                        <input type="url" id="facebook" name="facebook" 
                               class="form-input-modern" 
                               value="{{ old('facebook', $data['global_setting']->facebook ?? '') }}"
                               placeholder="https://facebook.com/yourpage">
                    </div>

                    <div class="form-group-modern">
                        <label for="twitter">
                            <i class="ri-twitter-x-fill"></i>
                            Twitter / X URL
                        </label>
                        <input type="url" id="twitter" name="twitter" 
                               class="form-input-modern" 
                               value="{{ old('twitter', $data['global_setting']->twitter ?? '') }}"
                               placeholder="https://twitter.com/yourhandle">
                    </div>

                    <div class="form-group-modern">
                        <label for="instagram">
                            <i class="ri-instagram-fill"></i>
                            Instagram URL
                        </label>
                        <input type="url" id="instagram" name="instagram" 
                               class="form-input-modern" 
                               value="{{ old('instagram', $data['global_setting']->instagram ?? '') }}"
                               placeholder="https://instagram.com/yourprofile">
                    </div>

                    <div class="form-group-modern">
                        <label for="youtube">
                            <i class="ri-youtube-fill"></i>
                            YouTube URL
                        </label>
                        <input type="url" id="youtube" name="youtube" 
                               class="form-input-modern" 
                               value="{{ old('youtube', $data['global_setting']->youtube ?? '') }}"
                               placeholder="https://youtube.com/yourchannel">
                    </div>

                    <div class="form-group-modern">
                        <label for="tiktok">
                            <i class="ri-tiktok-fill"></i>
                            TikTok URL
                        </label>
                        <input type="url" id="tiktok" name="tiktok" 
                               class="form-input-modern" 
                               value="{{ old('tiktok', $data['global_setting']->tiktok ?? '') }}"
                               placeholder="https://tiktok.com/@youraccount">
                    </div>

                    <div class="form-group-modern">
                        <label for="whatsapp">
                            <i class="ri-whatsapp-fill"></i>
                            WhatsApp Number
                        </label>
                        <input type="text" id="whatsapp" name="whatsapp" 
                               class="form-input-modern" 
                               value="{{ old('whatsapp', $data['global_setting']->whatsapp ?? '') }}"
                               placeholder="+1234567890">
                    </div>
                </div>
            </div>

            <!-- Branding Panel -->
            <div class="tab-content-panel" id="branding">
                <div class="section-title">
                    <i class="ri-image-2-line"></i>
                    Visual Identity
                </div>
                <p class="section-subtitle">Upload your logo, favicon, and default images</p>

                <div class="image-upload-container">
                    <!-- Site Logo -->
                    <div class="image-upload-card {{ !empty($data['global_setting']->logo ?? '') ? 'has-image' : '' }}">
                        <h6><i class="ri-image-line"></i> Site Logo</h6>
                        <span class="badge">Recommended: PNG, 200x50px</span>
                        <span class="upload-success"><i class="ri-check-line"></i> Uploaded</span>
                        
                        <div class="image-preview-modern" id="logoPreviewBox">
                            @if (!empty($data['global_setting']->logo ?? ''))
                                <img id="logoPreview" 
                                     src="{{ asset('uploads/images/site/' . $data['global_setting']->logo) }}"
                                     alt="Site Logo">
                            @else
                                <div class="image-placeholder" id="logoPlaceholder">
                                    <i class="ri-image-add-line"></i>
                                    <p>No Logo Uploaded</p>
                                </div>
                                <img id="logoPreview" style="display: none;">
                            @endif
                        </div>
                        
                        <div class="custom-file-input">
                            <input type="file" id="logoInput" name="logo" accept="image/*">
                            <label for="logoInput" class="file-input-label">
                                <i class="ri-upload-cloud-line"></i>
                                Choose Logo
                            </label>
                        </div>
                    </div>

                    <!-- Favicon -->
                    <div class="image-upload-card {{ !empty($data['global_setting']->favicon ?? '') ? 'has-image' : '' }}">
                        <h6><i class="ri-compass-3-line"></i> Favicon</h6>
                        <span class="badge">Recommended: ICO/PNG, 32x32px</span>
                        <span class="upload-success"><i class="ri-check-line"></i> Uploaded</span>
                        
                        <div class="image-preview-modern" id="faviconPreviewBox">
                            @if (!empty($data['global_setting']->favicon ?? ''))
                                <img id="faviconPreview" 
                                     src="{{ asset('uploads/images/site/' . $data['global_setting']->favicon) }}"
                                     alt="Favicon">
                            @else
                                <div class="image-placeholder" id="faviconPlaceholder">
                                    <i class="ri-image-add-line"></i>
                                    <p>No Favicon Uploaded</p>
                                </div>
                                <img id="faviconPreview" style="display: none;">
                            @endif
                        </div>
                        
                        <div class="custom-file-input">
                            <input type="file" id="faviconInput" name="favicon" accept="image/*">
                            <label for="faviconInput" class="file-input-label">
                                <i class="ri-upload-cloud-line"></i>
                                Choose Favicon
                            </label>
                        </div>
                    </div>

                    <!-- Default Image -->
                    <div class="image-upload-card {{ !empty($data['global_setting']->default_image ?? '') ? 'has-image' : '' }}">
                        <h6><i class="ri-landscape-line"></i> Default Share Image</h6>
                        <span class="badge">For Social Media Sharing</span>
                        <span class="upload-success"><i class="ri-check-line"></i> Uploaded</span>
                        
                        <div class="image-preview-modern" id="defaultImagePreviewBox">
                            @if (!empty($data['global_setting']->default_image ?? ''))
                                <img id="defaultImagePreview" 
                                     src="{{ asset('uploads/images/site/' . $data['global_setting']->default_image) }}"
                                     alt="Default Image">
                            @else
                                <div class="image-placeholder" id="defaultImagePlaceholder">
                                    <i class="ri-image-add-line"></i>
                                    <p>No Default Image</p>
                                </div>
                                <img id="defaultImagePreview" style="display: none;">
                            @endif
                        </div>
                        
                        <div class="custom-file-input">
                            <input type="file" id="defaultImageInput" name="default_image" accept="image/*">
                            <label for="defaultImageInput" class="file-input-label">
                                <i class="ri-upload-cloud-line"></i>
                                Choose Image
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="save-button-container">
            <button type="submit" class="btn-modern btn-primary-modern">
                <i class="ri-save-3-line"></i>
                Save All Settings
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-content-panel');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panels
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanels.forEach(panel => panel.classList.remove('active'));
            
            // Add active class to clicked button and corresponding panel
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
    
    // Image preview functionality
    const setupImagePreview = (inputId, previewId, placeholderId, cardClass) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        const card = input.closest('.image-upload-card');
        
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }
                    if (card) {
                        card.classList.add('has-image');
                    }
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Initial state check
        if (preview.src && preview.src.includes('http')) {
            if (placeholder) {
                placeholder.style.display = 'none';
            }
            preview.style.display = 'block';
        }
    };
    
    setupImagePreview('logoInput', 'logoPreview', 'logoPlaceholder');
    setupImagePreview('faviconInput', 'faviconPreview', 'faviconPlaceholder');
    setupImagePreview('defaultImageInput', 'defaultImagePreview', 'defaultImagePlaceholder');
    
    // Google Map Preview functionality
    const mapTextarea = document.getElementById('google_map');
    const mapPreviewContainer = document.getElementById('mapPreviewContainer');
    const mapPreviewWrapper = document.getElementById('mapPreviewWrapper');
    
    if (mapTextarea) {
        mapTextarea.addEventListener('input', function() {
            const mapCode = this.value.trim();
            
            if (mapCode) {
                // Show preview container
                mapPreviewContainer.style.display = 'block';
                
                // Update iframe
                mapPreviewWrapper.innerHTML = mapCode;
            } else {
                // Hide preview if empty
                mapPreviewContainer.style.display = 'none';
                mapPreviewWrapper.innerHTML = '';
            }
        });
    }
});
</script>

@endsection