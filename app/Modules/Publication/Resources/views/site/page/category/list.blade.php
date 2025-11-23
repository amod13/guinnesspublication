@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="{{ route('book.category.list', ['locale' => app()->getLocale()]) }}"
                        class="breadcrumb-link-amd">Category List</a>
                </li>
            </ol>
        </nav>
    </section>
    <section class="amd-category-section">
        <!-- search and filter  -->
        <div class="amd-book-search-page-wrapper container mb-4 border-bottom pb-3">
            <form action="{{ route('site.category.search', ['locale' => app()->getLocale()]) }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="input-group w-100">
                            <input type="text" class="form-control amd-book-search-page-input" name="keyword"
                                value="{{ request('keyword') }}" id="amdBookSearchPageInput" placeholder="search category.."
                                aria-label="Search">
                            <a href="{{ route('book.category.list', ['locale' => app()->getLocale()]) }}" class="d-none amd-category-search-clear amd-book-search-page-clear-btn "
                                id="amdBookSearchPageClearBtn" aria-label="Clear search">
                                <i class="bi bi-x-lg"></i>
                            </a>
                            <button class="btn btn-primary amd-book-search-page-main-btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="container">

            <div class="row row-cols-2 row-cols-md-4 g-3">
                @foreach ($data['activeBookCategories'] as $item)
                    <div class="col">
                        <a href="{{ route('book.list.by.category', ['locale' => app()->getLocale(), 'slug' => $item->slug]) }}"
                            class="amd-category-card">
                            <div class="d-flex align-items-center">
                                <div class="amd-category-icon me-3">
                                    <img src="{{ $item->getMediaUrl('thumbnail_image') }}" alt="{{ $item->name }}"
                                        class="img-fluid">
                                </div>
                                <div class="amd-category-text">
                                    <p class="mb-0">{{ $item->name }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @include('publication::site.page.pagination.pagination', ['paginator' => $data['activeBookCategories'], ])
        </div>
    </section>
@endsection
