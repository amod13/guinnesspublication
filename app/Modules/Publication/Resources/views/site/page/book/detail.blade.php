@extends('publication::site.main.app')
@section('content')
@section('meta')
    <!-- Open Graph -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $data['book']['record']->title ?? '' }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($data['book']['record']->content ?? ''), 150) }}">
    <meta property="og:image" content="{{ $data['book']['record']->getMediaUrl('thumbnail_image') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Publisher's Weekly">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data['book']['record']->title ?? '' }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($data['book']['record']->content ?? ''), 150) }}">
    <meta name="twitter:image" content="{{ $data['book']['record']->getMediaUrl('thumbnail_image') }}">
    <meta name="twitter:site" content="@amd_soft_services">
    <meta name="twitter:url" content="{{ url()->current() }}">
@endsection

<section class="amd-breadcrumb-section">
    <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
        <ol class="breadcrumb-list-amd">
            <li class="breadcrumb-item-amd">
                <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
            </li>
            <li class="breadcrumb-item-amd">
                <span class="breadcrumb-current-amd"
                    aria-current="page">{{ $data['book']['record']->category->name ?? '' }}</span>
            </li>
        </ol>
    </nav>
</section>

<section class="amd-flipbook-section" style="visibility:hidden; height:0;  transition: height 0.3s ease;">
    <div class="flipbook-container">
        <!-- Flipbook Wrapper -->
        <div class="flipbook-wrapper">
            <div class="flipbook-head container">
                <div
                    class="amd-book-detail-page-right-content row align-items-center justify-content-between gap-3 text-center text-md-start">

                    <!-- Back Button in Column -->
                    <div class="col-auto">
                        <a
                            href="{{ route('single.book.detail', ['locale' => request()->route('locale') ?? 'en', 'slug' => $data['book']['record']->slug ?? $data['book']['record']->id]) }}">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                    </div>

                    <!-- Book Info in Column -->
                    <div class="col amd-3d-flipbook-head">
                        <div class="amd-book-title-group">
                            <h1 class="amd-book-detail-page-title">
                                <strong>{{ $data['book']['record']->title ?? '' }}</strong>
                            </h1>
                            @if (!empty($data['book']['bookAuthorDetails']->name))
                                <p class="amd-book-detail-page-author">
                                    by {{ $data['book']['bookAuthorDetails']->name }}
                                </p>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
            <!-- Loader -->
            <div id="loader">
                <div class="spinner"></div>
                <p id="loader-text">Loading PDF...</p>
            </div>
            <!-- Flipbook Container -->
            <div id="flipbook" class="flipbook"></div>
            <!-- Hidden PDF Source -->
            @if ($data['book']['isLoginUser'] == true)
                {{-- Allow All Login User Pdf --}}
                <iframe src="{{ $data['book']['record']->getMediaUrl('pdf_file') }}" id="pdfSource"
                    style="display:none;" aria-hidden="true" class="faltu2"></iframe>
            @else
                {{-- Guest user PDF --}}
                <iframe src="{{ route('books.pdf', $data['book']['record']->id) }}" id="pdfSource"
                    style="display:none;" aria-hidden="true" class="faltu"></iframe>
            @endif
        </div>

        <!-- Flipbook Controls -->
        <div class="flipbook-controls">
            <button id="zoomIn" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
            <button id="zoomOut" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
        </div>
    </div>
</section>

<section class="amd-book-detail-page-wrapper container">
    <!-- Using a single container for logical flow -->
    <div class="row align-items-center g-4 g-lg-5" id="bookPart">
        <!-- Left Column (Image) - Stacks on top on mobile -->
        <div class="col-md-5 text-center text-md-start">
            <div class="amd-book-detail-page-cover">
                <!-- Replaced with a working placeholder image -->
                <img src="{{ $data['book']['record']->getMediaUrl('thumbnail_image') }}" alt="Harry Potter Book Cover"
                    class="amd-book-detail-page-cover-img d-block" />
            </div>
        </div>

        <!-- Right Column (Title/Author) - Stacks below image on mobile -->
        <div class="col-md-7 text-center text-md-start amd-book-detail-page-right-content">
            <h1 class="amd-book-detail-page-title">{{ $data['book']['record']->title }}</h1>
            @if (!empty($data['book']['bookAuthorDetails']->name))
                <p class="amd-book-detail-page-author">by {{ $data['book']['bookAuthorDetails']->name ?? '' }}</p>
            @endif
            <p class="amd-book-detail-page-summary mx-auto mx-md-0" style="max-width: 450px;">
                {!! $data['book']['record']->content ?? '' !!}
            </p>
        </div>
    </div>

    <!-- Full-width Info Card - Sits below the content above -->
    <div class="row">
        <div class="col-12">
            <div class="amd-book-detail-page-info-card">
                <!-- Actions Row -->
                <div class="d-flex justify-content-center justify-content-md-end">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 amd-book-detail-page-actions w-100"
                        style="max-width: 360px;">

                        <!-- Start Reading Button -->
                        <button type="button" class="amd-book-read-more-btn " id="startReadingPdf">
                            Start reading <i class="bi bi-arrow-right"></i>
                        </button>

                        <!-- Icon Group -->
                        <div class="amd-book-detail-page-icon-group position-relative">
                            <i class="bi {{ $data['book']['isBookmarked'] ? 'bi-bookmark-fill active' : 'bi-bookmark' }}"
                                data-book-id="{{ $data['book']['record']->id }}" id="bookMarkBook"></i>

                            <!-- Share Icon with Dropdown -->
                            <div class="dropdown d-inline-block">
                                <i class="bi bi-share" id="shareDropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false" role="button"></i>

                                <!-- Smooth Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end shadow amd-share-dropdown"
                                    aria-labelledby="shareDropdown">
                                    <!-- Facebook -->
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                            target="_blank">
                                            <i class="bi bi-facebook"></i> Facebook
                                        </a>
                                    </li>

                                    <!-- Twitter (X) -->
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($data['book']['record']->title ?? '') }}"
                                            target="_blank">
                                            <i class="bi bi-twitter"></i> Twitter (X)
                                        </a>
                                    </li>

                                    <!-- WhatsApp -->
                                    <li>
                                        <a class="dropdown-item"
                                            href="https://wa.me/?text={{ urlencode($data['book']['record']->title . ' ' . url()->current()) }}"
                                            target="_blank">
                                            <i class="bi bi-whatsapp"></i> WhatsApp
                                        </a>
                                    </li>
                                </ul>

                            </div>

                            <i class="bi bi-download"></i>
                        </div>
                    </div>
                </div>

                <!-- Details Row -->
                <div class="row g-5">
                    <div class="col-md-12">
                        @if (!empty($data['book']['record']->content))
                            <h5 class="amd-book-detail-page-section-title">Description</h5>
                            <p class="amd-book-detail-page-section-content">
                                {!! $data['book']['record']->content ?? '' !!}
                            </p>
                        @endif
                        <div class="d-flex align-items-center gap-3 amd-book-detail-page-review">
                            @if (!empty($data['book']['bookAuthorDetails']))
                                <img src="{{ $data['book']['bookAuthorDetails']->getMediaUrl('image') }}"
                                    alt="{{ $data['book']['bookAuthorDetails']->name ?? '' }}"
                                    class="amd-book-detail-page-review-avatar" />
                            @endif

                            <div>
                                <p class="mb-1 amd-book-detail-page-reviewer-name">
                                    {{ $data['book']['bookAuthorDetails']->name ?? '' }}</p>
                                @if (!empty($data['book']['bookAuthorDetails']->content))
                                    <p class="mb-0 amd-book-detail-page-review-text">
                                        {!! $data['book']['bookAuthorDetails']->content ?? '' !!}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</section>

@if ($data['book']['relatedBook']->count() > 0)
    <section class="amd-book-section">
        <div class="container">
            <div class="amd-book-section-bg-text">Related Books</div>
            <div class="amd-book-section-header">
                <h2 class="amd-global-title-highlight">Realated</h2>
                <a href="{{ route('book.list.by.category', [
                    'locale' => app()->getLocale(),
                    'slug' => $data['book']['record']->category->slug,
                ]) }}"
                    class="amd-book-view-all">

                    <!-- From Uiverse.io by Li-Deheng -->
                    <button class="button">
                        <span>View All</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 43">
                            <polygon points="39.58,4.46 44.11,0 66,21.5 44.11,43 39.58,38.54 56.94,21.5"></polygon>
                            <polygon points="19.79,4.46 24.32,0 46.21,21.5 24.32,43 19.79,38.54 37.15,21.5">
                            </polygon>
                            <polygon points="0,4.46 4.53,0 26.42,21.5 4.53,43 0,38.54 17.36,21.5"></polygon>
                        </svg>
                    </button>
                </a>
            </div>
            <div class="amd-book-section-carousel-wrapper">
                <button class="amd-book-section-nav amd-book-section-nav-prev" aria-label="Previous">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="amd-book-section-carousel">
                    @foreach ($data['book']['relatedBook'] as $item)
                        <a href="{{ route('single.book.detail', ['locale' => request()->route('locale') ?? 'en', 'slug' => $item->slug ?? $item->id]) }}"
                            class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                            alt="{{ $item->title }}">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <!-- UPDATED: Image of open book -->
                                        <img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                            alt="{{ $item->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>{{ $item->title }}</h3>
                            </div>
                        </a>
                    @endforeach

                </div>
                <button class="amd-book-section-nav amd-book-section-nav-next" aria-label="Next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>
@endif

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#bookMarkBook').on('click', function() {
            let icon = $(this);
            let bookId = $(this).data('book-id');

            $.ajax({
                url: "{{ route('site.books.favourite.toggle', ['locale' => app()->getLocale()]) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    book_id: bookId
                },
                success: function(response) {
                    if (response.status === 'added') {
                        icon.removeClass('bi-bookmark').addClass('bi-bookmark-fill active');
                    } else if (response.status === 'removed') {
                        icon.removeClass('bi-bookmark-fill active').addClass('bi-bookmark');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401 && xhr.responseJSON?.redirect) {
                        // Redirect to login if not authenticated
                        window.location.href = xhr.responseJSON.redirect;
                    } else {
                        alert('An error occurred.');
                        console.log(xhr.responseText);
                    }
                }
            });
        });
    });
</script>
@endpush
