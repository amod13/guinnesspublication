@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="{{ route('site.blog.list', ['locale' => app()->getLocale()]) }}" class="breadcrumb-link-amd">Blog List</a>
                </li>
            </ol>
        </nav>
    </section>

    <section class="amd-blog-page-container">
        <div class="container">
            <div class="amd-blog-page-filters">
                <!-- search and filter  -->
                <div class="amd-book-search-page-wrapper container mb-4 border-bottom pb-3">
                    <form action="{{ route('site.blog.search', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-4">
                                <!-- Filter dropdown -->
                                <select class="form-select amd-book-search-page-input" name="category_id" id="amdBookSearchFilter"
                                    aria-label="Filter books">
                                    <option value="" selected>All Categories</option>
                                    @foreach ($data['activeBlogCategories'] as $item)
                                         <option value="{{ $item->id }}" {{ request('category_id') == $item->id ? 'selected' : '' }}>{{ $item->title  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control amd-book-search-page-input"
                                        id="amdBookSearchPageInput" name="keywords" placeholder="Search blog..." aria-label="Search"  value="{{ request('keywords') }}">
                                    <a href="{{ route('site.blog.list', ['locale' => app()->getLocale()]) }}"
                                        class="d-none amd-category-search-clear amd-book-search-page-clear-btn "
                                        id="amdBookSearchPageClearBtn" aria-label="Clear search">
                                        <i class="bi bi-x-lg"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                  <a href="{{ route('site.blog.list', ['locale' => app()->getLocale()]) }}" class="btn btn-danger">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                                <button class="btn btn-primary amd-book-search-page-main-btn" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="amd-blog-page-grid">
                    @foreach ($data['blogs'] as $item)
                        <article class="amd-blog-page-card">
                            <a href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? ($item->id ?? '')]) }}"
                                class="amd-blog-page-card-image-link"><img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                    alt="{{ $item->title ?? '' }}" class="amd-blog-page-card-image"></a>
                            <div class="amd-blog-page-card-content">
                                <div class="amd-blog-page-card-meta"><i class="bi bi-megaphone-fill"></i>
                                    {{ $item->blogCategory->title ?? '' }}
                                    <span class="date">{{ $item->created_at->format('M d, Y') }}</span>
                                </div>
                                <h2 class="amd-blog-page-card-title"><a
                                        href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? ($item->id ?? '')]) }}">{{ $item->title ?? '' }}</a>
                                </h2>
                                <p class="amd-blog-page-card-excerpt">
                                    {!! $item->content ?? '' !!}
                                </p>
                                <a href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? ($item->id ?? '')]) }}"
                                    class="amd-blog-page-card-read-more">Learn More &rarr;</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- laod more btn -->
            <div class="text-center mt-5">
                <div class="amd-book-view-all">
                    <button class="button" id="loadMoreBtn">
                        <span class="btn-text">Load More</span>
                        <svg class="btn-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 43">
                            <polygon points="39.58,4.46 44.11,0 66,21.5 44.11,43 39.58,38.54 56.94,21.5"></polygon>
                            <polygon points="19.79,4.46 24.32,0 46.21,21.5 24.32,43 19.79,38.54 37.15,21.5">
                            </polygon>
                            <polygon points="0,4.46 4.53,0 26.42,21.5 4.53,43 0,38.54 17.36,21.5"></polygon>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </section>
@endsection
