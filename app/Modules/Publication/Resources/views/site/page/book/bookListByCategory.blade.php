@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">Book List</a>
                </li>
            </ol>
        </nav>
    </section>

    <!-- MAIN CONTENT AREA -->
    <section class="container amd-book-list-container">
        <div class="row g-4">

            <!-- SIDEBAR COLUMN -->
            <aside class="col-lg-3">
                <div class="offcanvas-lg offcanvas-start amd-book-list-page-sidebar-sticky" tabindex="-1"
                    id="amdBookListPageOffcanvas" aria-labelledby="amdBookListPageOffcanvasLabel">

                    <!-- Offcanvas Header (This is only visible on mobile/tablet) -->
                    <div class="offcanvas-header d-lg-none">
                        <h5 class="offcanvas-title" id="amdBookListPageOffcanvasLabel">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            data-bs-target="#amdBookListPageOffcanvas" aria-label="Close"></button>
                    </div>

                    <!-- Sidebar/Offcanvas Body (This contains the actual filter content) -->
                    <div class="offcanvas-body">
                        <form action="{{ route('site.books.search', ['locale' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            <h4 class="mb-3 d-none d-lg-block">Filters</h4>
                            <!-- Search Bar -->
                            <div class="mb-4 amd-book-list-page-search-bar">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="Search Books..."
                                        aria-label="Search books" value="{{ request('keyword') }}">
                                </div>
                            </div>
                            <!-- Filter Accordion -->
                            <div class="accordion accordion-flush amd-book-list-page-accordion" id="filterAccordion">
                                <!-- Category -->
                                <div class="accordion-item active">
                                    <h2 class="accordion-header" id="h-cat"><button class="accordion-button"
                                            type="button" data-bs-toggle="collapse" data-bs-target="#c-cat"
                                            aria-expanded="true" aria-controls="c-cat">Category</button></h2>
                                    <div id="c-cat" class="accordion-collapse collapse show" aria-labelledby="h-cat">
                                        <div class="accordion-body amd-book-list-page-filter-list">
                                            @foreach ($data['activeCategories'] as $item)
                                                <div class="form-check">
                                                    <input name="category_id[]" class="form-check-input" type="checkbox"
                                                        value="{{ $item->id }}" id="cat{{ $item->id }}"
                                                        @if (is_array(request('category_id')) && in_array($item->id, request('category_id'))) checked @endif>
                                                    <label class="form-check-label" for="cat{{ $item->id }}">
                                                        {{ $item->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="amd-filter-apply-btn-wrapper">
                                <button type="submit" class="amd-filter-apply-btn">Apply Filters</button>
                            </div>
                        </form>

                    </div>
                </div>
            </aside>

            <!-- BOOK GRID COLUMN -->
            <div class="col-lg-9">
                <!-- Top Bar with sorting, counts, and view toggles -->
                <div class="amd-book-list-page-top-bar">
                    <span class="text-muted">
                        Showing {{ $data['booksByCategories']->firstItem() }}–
                        {{ $data['booksByCategories']->lastItem() }}
                        of {{ $data['booksByCategories']->total() }} books
                    </span>

                    <div class="d-flex align-items-center gap-3">
                        <!-- View toggle buttons (Only visible on large screens) -->
                        <div class="amd-book-list-page-view-toggle btn-group d-none d-lg-flex" role="group">
                            <button type="button" class="btn active" id="amd-book-list-page-grid-less-btn"
                                title="Compact View"><i class="bi bi-grid-fill"></i></button>
                            <button type="button" class="btn" id="amd-book-list-page-grid-expend-btn"
                                title="Expanded View"><i class="bi bi-grid-3x3-gap-fill"></i></button>
                        </div>
                        <!-- Filter button (Only visible on small screens to open offcanvas) -->
                        <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#amdBookListPageOffcanvas" aria-controls="amdBookListPageOffcanvas">
                            <i class="bi bi-funnel-fill"></i> Filters
                        </button>
                    </div>
                </div>


                <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4" id="amd-book-list-page-book-grid">
                    @foreach ($data['booksByCategories'] as $item)
                        <div class="col">
                            <a href="{{ route('single.book.detail', ['locale' => request()->route('locale') ?? 'en', 'slug' => $item->slug ?? $item->id]) }}"
                                class="card amd-book-list-page-book-card">
                                <img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                    class="card-img-top amd-book-list-page-book-card-img" alt="Book Cover">
                                <div class="card-body amd-book-list-head">
                                    <h5 class="card-title amd-book-list-page-book-title">{{ $item->title }}</h5>
                                    <p class="card-text amd-book-list-page-book-author">{{ $item->author->name ?? '' }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @include('publication::site.page.pagination.pagination', [
                    'paginator' => $data['booksByCategories'],
                ])
            </div>
        </div>
    </section>
@endsection
