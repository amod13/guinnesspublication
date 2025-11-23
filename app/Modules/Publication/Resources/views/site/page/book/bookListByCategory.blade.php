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
                        <h4 class="mb-3 d-none d-lg-block">Filters</h4>

                        <!-- Search Bar -->
                        <div class="mb-4 amd-book-list-page-search-bar">
                            <form action="{{ route('global.search', ['locale' => app()->getLocale()]) }}" method="GET">

                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword"
                                        placeholder="Search Books..." aria-label="Search books"
                                        value="{{ request('keyword') }}">
                                    <button class="btn" type="button" aria-label="Search"><i
                                            class="bi bi-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <!-- Category Filter -->
                        <div class="amd-book-list-page-filter-section">
                            <h5 class="amd-book-list-page-filter-title border-bottom pt-1">Category</h5>
                            <ul class="list-unstyled amd-book-list-page-filter-links">
                                @foreach ($data['activeCategories'] as $item)
                                    <li>
                                        <a href="{{ route('book.list.by.category', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}"
                                            class="amd-book-list-page-filter-link {{ request()->route('slug') == $item->slug ? 'active' : '' }}">
                                            {{ $item->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
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
