@extends('admin.main.app')
@section('content')

<style>
    :root {
        @foreach ($settings as $setting)
            --{{ str_replace('_', '-', $setting->key_name) }}: {{ $setting->value }};
        @endforeach
        --theme-primary: #6366f1;
        --theme-primary-dark: #4f46e5;
        --theme-success: #10b981;
        --theme-gray-50: #f9fafb;
        --theme-gray-100: #f3f4f6;
        --theme-gray-200: #e5e7eb;
        --theme-gray-300: #d1d5db;
        --theme-gray-400: #9ca3af;
        --theme-gray-500: #6b7280;
        --theme-gray-600: #4b5563;
        --theme-gray-700: #374151;
        --theme-gray-800: #1f2937;
        --theme-gray-900: #111827;
    }

    .theme-settings-wrapper {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    .theme-hero {
        background: linear-gradient(135deg, var(--theme-primary) 0%, var(--theme-primary-dark) 100%);
        border-radius: 2rem;
        padding: 3rem 2.5rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.3);
    }

    .theme-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: heroFloat 20s ease-in-out infinite;
    }

    @keyframes heroFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(-30px, 30px) scale(1.1); }
    }

    .theme-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0 0 0.75rem 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .theme-hero p {
        font-size: 1.125rem;
        opacity: 0.95;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .theme-content-grid {
        display: grid;
        grid-template-columns: 500px 1fr;
        gap: 2rem;
        align-items: start;
    }

    .theme-controls-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 2rem;
        max-height: calc(100vh - 4rem);
        overflow-y: auto;
    }

    .theme-controls-card::-webkit-scrollbar {
        width: 8px;
    }

    .theme-controls-card::-webkit-scrollbar-track {
        background: var(--theme-gray-100);
        border-radius: 10px;
    }

    .theme-controls-card::-webkit-scrollbar-thumb {
        background: var(--theme-gray-300);
        border-radius: 10px;
    }

    .theme-controls-card::-webkit-scrollbar-thumb:hover {
        background: var(--theme-gray-400);
    }

    .controls-header {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--theme-gray-200);
    }

    .controls-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--theme-gray-900);
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .controls-header p {
        color: var(--theme-gray-500);
        margin: 0;
        font-size: 0.95rem;
    }

    .color-grid {
        display: grid;
        gap: 1.5rem;
    }

    .color-control {
        background: var(--theme-gray-50);
        border: 2px solid var(--theme-gray-200);
        border-radius: 1rem;
        padding: 1.25rem;
        transition: all 0.3s ease;
    }

    .color-control:hover {
        border-color: var(--theme-primary);
        box-shadow: 0 8px 16px -4px rgba(99, 102, 241, 0.2);
        transform: translateY(-2px);
    }

    .color-control label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-weight: 600;
        color: var(--theme-gray-800);
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .color-label-text {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .color-label-icon {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        border: 2px solid var(--theme-gray-300);
        transition: all 0.2s ease;
    }

    .color-input-wrapper {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .color-picker-btn {
        position: relative;
        width: 70px;
        height: 50px;
        border: 3px solid var(--theme-gray-300);
        border-radius: 0.75rem;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .color-picker-btn:hover {
        border-color: var(--theme-primary);
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(99, 102, 241, 0.3);
    }

    .color-picker-btn input[type="color"] {
        position: absolute;
        inset: -5px;
        width: calc(100% + 10px);
        height: calc(100% + 10px);
        border: none;
        cursor: pointer;
    }

    .color-text-input {
        flex: 1;
        padding: 0.875rem 1rem;
        border: 2px solid var(--theme-gray-200);
        border-radius: 0.75rem;
        font-family: 'Courier New', monospace;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--theme-gray-800);
        background: white;
        transition: all 0.2s ease;
        text-transform: uppercase;
    }

    .color-text-input:focus {
        outline: none;
        border-color: var(--theme-primary);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .save-btn-container {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--theme-gray-200);
    }

    .save-btn {
        width: 100%;
        padding: 1.25rem;
        border: none;
        border-radius: 1rem;
        background: linear-gradient(135deg, var(--theme-success) 0%, #059669 100%);
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 10px 20px -8px rgba(16, 185, 129, 0.5);
    }

    .save-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.6);
    }

    .save-btn i {
        font-size: 1.3rem;
    }

    .preview-card {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .preview-header {
        background: linear-gradient(135deg, var(--theme-gray-100) 0%, var(--theme-gray-200) 100%);
        padding: 1.75rem 2rem;
        border-bottom: 2px solid var(--theme-gray-200);
    }

    .preview-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--theme-gray-900);
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .preview-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .preview-btn {
        padding: 0.625rem 1.25rem;
        border: 2px solid var(--theme-gray-300);
        border-radius: 0.75rem;
        background: white;
        color: var(--theme-gray-700);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .preview-btn:hover {
        border-color: var(--theme-primary);
        color: var(--theme-primary);
        background: var(--theme-gray-50);
        transform: translateY(-1px);
    }

    .preview-btn i {
        font-size: 1rem;
    }

    .iframe-wrapper {
        position: relative;
        background: var(--theme-gray-100);
        padding: 2rem;
    }

    .iframe-container {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.2);
        background: white;
        position: relative;
    }

    .iframe-loading {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: white;
        z-index: 10;
    }

    .iframe-loading.hidden {
        display: none;
    }

    .spinner {
        width: 50px;
        height: 50px;
        border: 4px solid var(--theme-gray-200);
        border-top-color: var(--theme-primary);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    #site-preview {
        width: 100%;
        height: 700px;
        border: none;
        display: block;
        background: white;
    }

    .reset-btn {
        padding: 0.625rem 1.25rem;
        border: 2px solid #ef4444;
        border-radius: 0.75rem;
        background: white;
        color: #ef4444;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reset-btn:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-1px);
    }

    @media (max-width: 1200px) {
        .theme-content-grid {
            grid-template-columns: 1fr;
        }

        .theme-controls-card {
            position: relative;
            top: 0;
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .theme-hero {
            padding: 2rem 1.5rem;
        }

        .theme-hero h1 {
            font-size: 1.75rem;
        }

        .preview-actions {
            flex-wrap: wrap;
        }

        #site-preview {
            height: 500px;
        }
    }

    /* Color category badges */
    .color-category {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .category-primary {
        background: #dbeafe;
        color: #1e40af;
    }

    .category-background {
        background: #fef3c7;
        color: #92400e;
    }

    .category-text {
        background: #e0e7ff;
        color: #4338ca;
    }

    .category-accent {
        background: #dcfce7;
        color: #166534;
    }
</style>

<div class="theme-settings-wrapper">
    <!-- Hero Section -->
    <div class="theme-hero">
        <h1>
            <i class="ri-palette-line"></i>
            Theme Customization
        </h1>
        <p>Personalize your website's color scheme with live preview. Changes reflect instantly!</p>
    </div>

    <form action="{{ route('theme-settings.store') }}" method="POST">
        @csrf

        <div class="theme-content-grid">
            <!-- Color Controls Sidebar -->
            <div class="theme-controls-card">
                <div class="controls-header">
                    <h3>
                        <i class="ri-paint-brush-line"></i>
                        Color Palette
                    </h3>
                    <p>Adjust colors and see changes in real-time</p>
                </div>

                <div class="color-grid">
                    @foreach ($settings as $setting)
                        @php
                            // Determine category for badge
                            $category = 'primary';
                            if (str_contains($setting->key_name, 'background')) {
                                $category = 'background';
                            } elseif (str_contains($setting->key_name, 'text')) {
                                $category = 'text';
                            } elseif (str_contains($setting->key_name, 'accent') || str_contains($setting->key_name, 'secondary')) {
                                $category = 'accent';
                            }
                        @endphp
                        
                        <div class="color-control">
                            <label for="{{ $setting->key_name }}">
                                <span class="color-label-text">
                                    <span class="color-label-icon" style="background-color: {{ $setting->value }}"></span>
                                    <span>{{ $setting->label }}</span>
                                </span>
                                <span class="color-category category-{{ $category }}">
                                    {{ ucfirst($category) }}
                                </span>
                            </label>
                            
                            <div class="color-input-wrapper">
                                <div class="color-picker-btn">
                                    <input 
                                        type="color" 
                                        id="{{ $setting->key_name }}"
                                        class="theme-input"
                                        name="settings[{{ $setting->key_name }}]"
                                        data-css-var="--{{ str_replace('_', '-', $setting->key_name) }}"
                                        data-icon-id="icon-{{ $setting->key_name }}"
                                        value="{{ old('settings.' . $setting->key_name, $setting->value) }}"
                                    >
                                </div>
                                <input 
                                    type="text"
                                    class="color-text-input"
                                    id="text-{{ $setting->key_name }}"
                                    value="{{ old('settings.' . $setting->key_name, $setting->value) }}"
                                    maxlength="7"
                                    placeholder="#000000"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="save-btn-container">
                    <button type="button" class="reset-btn" onclick="resetColors()" style="width: 100%; margin-bottom: 1rem;">
                        <i class="ri-restart-line"></i>
                        Reset to Default
                    </button>
                    <button type="submit" class="save-btn">
                        <i class="ri-save-line"></i>
                        Save Theme Colors
                    </button>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="preview-card">
                <div class="preview-header">
                    <h3>
                        <i class="ri-eye-line"></i>
                        Live Preview
                    </h3>
                    <div class="preview-actions">
                        <button type="button" class="preview-btn" onclick="refreshPreview()">
                            <i class="ri-refresh-line"></i>
                            Refresh Preview
                        </button>
                        <button type="button" class="preview-btn" onclick="openInNewTab()">
                            <i class="ri-external-link-line"></i>
                            Open in New Tab
                        </button>
                    </div>
                </div>

                <div class="iframe-wrapper">
                    <div class="iframe-container">
                        <div class="iframe-loading" id="iframeLoading">
                            <div class="spinner"></div>
                        </div>
                        <iframe 
                            id="site-preview" 
                            src="{{ url('/') }}"
                            onload="hideLoading()"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sync color picker with text input
    document.querySelectorAll('.theme-input').forEach(colorInput => {
        const textInputId = 'text-' + colorInput.id;
        const textInput = document.getElementById(textInputId);
        const iconId = colorInput.dataset.iconId;
        const icon = document.querySelector(`[style*="background-color: ${colorInput.value}"]`);
        
        // Color picker changes text input
        colorInput.addEventListener('input', function() {
            const value = this.value;
            textInput.value = value.toUpperCase();
            updateThemeColor(this.dataset.cssVar, value);
            
            // Update icon color
            const iconElement = this.closest('.color-control').querySelector('.color-label-icon');
            if (iconElement) {
                iconElement.style.backgroundColor = value;
            }
        });
        
        // Text input changes color picker
        textInput.addEventListener('input', function() {
            let value = this.value.trim();
            
            // Auto-add # if missing
            if (value && !value.startsWith('#')) {
                value = '#' + value;
                this.value = value;
            }
            
            // Validate hex color
            if (/^#[0-9A-F]{6}$/i.test(value)) {
                colorInput.value = value;
                updateThemeColor(colorInput.dataset.cssVar, value);
                
                // Update icon color
                const iconElement = this.closest('.color-control').querySelector('.color-label-icon');
                if (iconElement) {
                    iconElement.style.backgroundColor = value;
                }
            }
        });
    });
});

function updateThemeColor(cssVar, value) {
    if (!cssVar || !value) return;
    
    // Update parent document
    document.documentElement.style.setProperty(cssVar, value);
    
    // Try to update iframe content (if same origin)
    try {
        const iframe = document.getElementById('site-preview');
        if (iframe && iframe.contentDocument) {
            iframe.contentDocument.documentElement.style.setProperty(cssVar, value);
        }
    } catch (e) {
        console.log('Cannot update iframe styles (cross-origin)');
    }
}

function refreshPreview() {
    const iframe = document.getElementById('site-preview');
    const loading = document.getElementById('iframeLoading');
    
    loading.classList.remove('hidden');
    iframe.src = iframe.src;
}

function openInNewTab() {
    window.open('{{ url("/") }}', '_blank');
}

function hideLoading() {
    const loading = document.getElementById('iframeLoading');
    setTimeout(() => {
        loading.classList.add('hidden');
    }, 500);
}

function resetColors() {
    if (confirm('Are you sure you want to reset all colors to default? This will reload the page.')) {
        location.reload();
    }
}

// Show loading initially
window.addEventListener('load', function() {
    setTimeout(() => {
        hideLoading();
    }, 1000);
});
</script>

@endsection