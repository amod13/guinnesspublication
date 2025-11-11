@extends('admin.main.app')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Customize Theme Colors</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('theme-settings.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            @foreach ($settings as $setting)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="{{ $setting->key_name }}" class="form-label">
                                            {{ $setting->label }}
                                        </label>
                                        <input type="{{ $setting->type }}" class="form-control theme-input"
                                            id="{{ $setting->key_name }}" name="settings[{{ $setting->key_name }}]"
                                            data-css-var="--{{ str_replace('_', '-', $setting->key_name) }}"
                                            value="{{ old('settings.' . $setting->key_name, $setting->value) }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Live Preview</h4>
                </div>
                <div class="card-body">
                    <div class="preview-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">Live preview of your website</small>
                            <button class="btn btn-sm btn-outline-secondary" onclick="refreshPreview()">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                        <iframe id="site-preview" src="{{ url('/') }}"
                            style="width: 100%; height: 600px; border: 1px solid #ddd; border-radius: 8px;" frameborder="0">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            @foreach ($settings as $setting)
                --{{ str_replace('_', '-', $setting->key_name) }}: {{ $setting->value }};
            @endforeach
        }

        .preview-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            font-family: Arial, sans-serif;
        }

        .preview-header {
            background: var(--primary-color, #007bff);
            color: white;
            padding: 1rem;
        }

        .preview-nav {
            margin-top: 0.5rem;
        }

        .preview-nav a {
            color: white;
            text-decoration: none;
            margin-right: 1rem;
            opacity: 0.9;
        }

        .preview-nav a:hover {
            opacity: 1;
        }

        .preview-content {
            background: var(--background-color, #ffffff);
            color: var(--text-color, #333333);
        }

        .preview-hero {
            background: var(--secondary-color, #6c757d);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .preview-btn {
            background: var(--accent-color, #28a745);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            margin-top: 1rem;
        }

        .preview-section {
            padding: 2rem;
        }

        .preview-cards {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-card {
            flex: 1;
            border: 1px solid var(--border-color, #dee2e6);
            padding: 1rem;
            border-radius: 4px;
            background: var(--card-background, #f8f9fa);
        }

        .preview-footer {
            background: var(--footer-background, #343a40);
            color: var(--footer-text, #ffffff);
            padding: 1rem;
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.theme-input').on('input change', function() {
                const cssVar = $(this).data('css-var');
                const value = $(this).val();

                if (cssVar && value) {
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
            });
        });

        function refreshPreview() {
            const iframe = document.getElementById('site-preview');
            iframe.src = iframe.src;
        }
    </script>
@endpush
