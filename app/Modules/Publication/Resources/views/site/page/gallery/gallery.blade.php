@extends('publication::site.main.app')
@section('content')
        <!-- breadcum -->
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">Gallery</a>
                </li>
            </ol>
        </nav>
    </section>

    <!-- gallery section -->
    <section id="core-services-section" class="amd-soft-content-section ">
      <div class="container">
        <!-- <h2 class="amd-soft-section-title">Gallery</h2> -->


        <!-- Filter Navigation -->
        <div class="amd-gallery-filter-nav amd-soft-fade-in-section">
          <div class="row">
            <div class="col-lg-8">
              <h6 class="amd-section-title">Filter by Category</h6>
              <ul class="nav nav-pills justify-content-start flex-wrap" id="galleryCategoryFilter" role="tablist">
                @foreach($data['galleryCategories'] as $index => $category)
                <li class="nav-item" role="presentation"><button class="nav-link {{ $index === 0 ? 'active' : '' }}"
                    data-filter="{{ $category->id }}">{{ $category->title }}</button></li>
                @endforeach
              </ul>
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
              <h6 class="amd-section-title">Filter by Media Type</h6>
              <ul class="nav nav-pills justify-content-start justify-content-lg-start flex-wrap" id="galleryTypeFilter"
                role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active" data-filter="*">All
                    Types</button></li>
                @php
                  $fileTypes = $data['gallaries']->pluck('file_type')->unique()->filter();
                @endphp
                @foreach($fileTypes as $type)
                <li class="nav-item" role="presentation"><button class="nav-link" data-filter="{{ $type }}">{{ ucfirst($type) }}s</button>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>

        <!-- Masonry Grid with Dynamic Items -->
        <div class="amd-gallery-masonry-container" id="galleryGrid">
          @foreach($data['gallaries'] as $gallery)
          <div class="amd-gallery-item amd-soft-fade-in-section"
               data-category="{{ $gallery->category_id }}"
               data-type="{{ $gallery->file_type }}"
               data-src="{{ $gallery->file_type === 'video' ? $gallery->video_url : asset('storage/gallery/' . $gallery->image) }}"
               data-title="{{ $gallery->caption ?? 'Gallery Item' }}"
               data-description="{{ $gallery->caption ?? '' }}">

            <div class="amd-gallery-image-wrapper">
              @if($gallery->file_type === 'video')
                @php
                  // Extract video thumbnail from YouTube/Vimeo URLs
                  $videoId = '';
                  $thumbnailUrl = '';
                  if (strpos($gallery->video_url, 'youtube.com') !== false || strpos($gallery->video_url, 'youtu.be') !== false) {
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $gallery->video_url, $matches);
                    $videoId = $matches[1] ?? '';
                    $thumbnailUrl = "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
                  } elseif (strpos($gallery->video_url, 'vimeo.com') !== false) {
                    preg_match('/vimeo\.com\/(\d+)/', $gallery->video_url, $matches);
                    $videoId = $matches[1] ?? '';
                    $thumbnailUrl = "https://vumbnail.com/{$videoId}.jpg";
                  }
                @endphp
                <img src="{{ $thumbnailUrl ?: 'https://via.placeholder.com/400x300?text=Video' }}" alt="{{ $gallery->caption }}">
                <div class="amd-gallery-play-icon"><i class="bi bi-play-circle-fill"></i></div>
              @else
                <img src="{{ asset('storage/gallery/'. $gallery->image) }}" alt="{{ $gallery->caption }}">
              @endif
            </div>
            <div class="amd-gallery-content">
              <h5 class="amd-gallery-title">{{ $gallery->caption ?? 'Gallery Item' }}</h5>
              <div class="amd-gallery-info">
                <span class="amd-gallery-category text-capitalize">{{ $gallery->category->title ?? 'General' }}</span>
                <span class="amd-gallery-type-icon">
                  @if($gallery->file_type === 'video')
                    <i class="bi bi-play-btn"></i>
                  @else
                    <i class="bi bi-image"></i>
                  @endif
                </span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Bootstrap Modal for Lightbox -->
      <div class="modal fade amd-gallery-modal" id="galleryLightbox" tabindex="-1"
        aria-labelledby="galleryLightboxLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="lightboxTitle"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="lightboxBody">
              <!-- Media content will be injected here -->
            </div>
            <div class="modal-footer">
              <p class="modal-description" id="lightboxDescription"></p>
            </div>
          </div>
        </div>
      </div>
    </section>



    @endsection

    @push('styles')
    <style>
    .amd-gallery-play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.9);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        pointer-events: none;
    }

    .amd-gallery-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .amd-gallery-item[data-type="video"] .amd-gallery-image-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.3);
        pointer-events: none;
    }
    </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // --- Initialize Components ---
                var $galleryGrid = $('#galleryGrid');
                var $categoryFilter = $('#galleryCategoryFilter');
                var $typeFilter = $('#galleryTypeFilter');
                var galleryLightbox = new bootstrap.Modal(document.getElementById('galleryLightbox'));
                var $lightboxBody = $('#lightboxBody');
                var $lightboxTitle = $('#lightboxTitle');
                var $lightboxDescription = $('#lightboxDescription');

                // --- Functions ---
                function applyFilters() {
                    var categoryFilter = $categoryFilter.find('.nav-link.active').data('filter');
                    var typeFilter = $typeFilter.find('.nav-link.active').data('filter');

                    $galleryGrid.find('.amd-gallery-item').each(function() {
                        var itemCategory = $(this).data('category');
                        var itemType = $(this).data('type');

                        var categoryMatch = (itemCategory == categoryFilter);
                        var typeMatch = (typeFilter === '*') || (itemType === typeFilter);

                        if (categoryMatch && typeMatch) {
                            $(this).show(400);
                        } else {
                            $(this).hide(400);
                        }
                    });
                }

                // --- Event Handlers ---

                // Filter clicks
                $categoryFilter.on('click', '.nav-link', function() {
                    $categoryFilter.find('.nav-link').removeClass('active');
                    $(this).addClass('active');
                    applyFilters();
                });

                $typeFilter.on('click', '.nav-link', function() {
                    $typeFilter.find('.nav-link').removeClass('active');
                    $(this).addClass('active');
                    applyFilters();
                });

                // Apply initial filter on page load
                applyFilters();

                // --- Gallery item click with multiple images support ---
                $galleryGrid.on('click', '.amd-gallery-item', function() {
                    var $item = $(this);
                    var type = $item.data('type');
                    var src = $item.data('src');
                    var title = $item.data('title');
                    var description = $item.data('description');
                    var gallery = $item.data('gallery'); // Expect JSON array or comma-separated list

                    $lightboxTitle.text(title);
                    $lightboxDescription.text(description);

                    var mediaHTML = '';

                    // Case 1: Multiple images in gallery
                    if (gallery) {
                        // Convert string to array if not already
                        var images = [];
                        try {
                            images = typeof gallery === 'string' ? JSON.parse(gallery) : gallery;
                        } catch {
                            images = gallery.split(',');
                        }

                        var carouselId = 'amdGalleryCarousel';
                        mediaHTML += '<div id="' + carouselId +
                            '" class="carousel slide" data-bs-ride="carousel">';
                        mediaHTML += '<div class="carousel-inner">';
                        $.each(images, function(index, img) {
                            mediaHTML += `
                    <div class="carousel-item ${index === 0 ? 'active' : ''}">
                        <img src="${img}" class="d-block w-100 rounded" alt="Slide ${index + 1}">
                    </div>`;
                        });
                        mediaHTML += '</div>';
                        mediaHTML += `
                <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>`;
                        mediaHTML += '</div>';
                    }

                    // Case 2: Single media item
                    else {
                        switch (type) {
                            case 'image':
                            case 'image':
                                mediaHTML = '<img src="' + src + '" class="img-fluid rounded w-100" alt="' +
                                    title + '">';
                                break;
                            case 'video':
                                // Handle YouTube/Vimeo embeds
                                if (src.includes('youtube.com') || src.includes('youtu.be')) {
                                    var videoId = '';
                                    var match = src.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
                                    if (match) videoId = match[1];
                                    mediaHTML = '<div class="ratio ratio-16x9"><iframe src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe></div>';
                                } else if (src.includes('vimeo.com')) {
                                    var vimeoId = '';
                                    var match = src.match(/vimeo\.com\/(\d+)/);
                                    if (match) vimeoId = match[1];
                                    mediaHTML = '<div class="ratio ratio-16x9"><iframe src="https://player.vimeo.com/video/' + vimeoId + '" frameborder="0" allowfullscreen></iframe></div>';
                                } else {
                                    // Direct video file
                                    mediaHTML = '<div class="ratio ratio-16x9"><video controls autoplay class="w-100 rounded"><source src="' + src + '" type="video/mp4"></video></div>';
                                }
                                break;
                        }
                    }

                    $lightboxBody.html(mediaHTML);
                    galleryLightbox.show();
                });

                // Clear modal on close
                $('#galleryLightbox').on('hidden.bs.modal', function() {
                    $lightboxBody.html('');
                });
            });
        </script>
    @endpush
