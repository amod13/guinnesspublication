@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">{{ $data['blog']->blogCategory->title ?? '' }}</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">{{ $data['blog']->title ?? '' }}</a>
                </li>
            </ol>
        </nav>
    </section>

    <section class="amd-blog-detail-container">
        <div class="container">
          <header class="amd-blog-detail-header">
            <h1>{{ $data['blog']->title ?? '' }}</h1>
            <div class="amd-blog-detail-meta">
                <span>By <a href="#" class="amd-blog-detail-author">{{ $data['blog']->author_name ?? '' }}</a></span>
                <span>Last updated: {{ $data['blog']->updated_at->format('M d, Y') }}</span>
                <span><i class="bi bi-clock"></i> {{ $data['blog']->reading_time ?? '' }}</span>
            </div>
        </header>

        <figure class="amd-blog-detail-featured-image">
            <img src="{{ $data['blog']->getMediaUrl('thumbnail_image') }}" alt="{{ $data['blog']->title ?? '' }}">
        </figure>
        <div class="amd-blog-detail-main-layout">
            <aside class="amd-blog-detail-sidebar">
                <div class="amd-blog-detail-sidebar-box amd-blog-detail-toc">
                    <h3>In This Article</h3>
                    <ul>
                        <li><a href="#why-social-media">Why Social Media Matters</a></li>
                        <li><a href="#find-your-platform">Find Your Niche Platform</a></li>
                        <li><a href="#power-of-visuals">The Power of Visuals</a></li>
                        <li><a href="#engage-and-connect">Engage and Connect</a></li>
                    </ul>
                </div>
                <div class="amd-blog-detail-sidebar-box amd-blog-detail-subscribe">
                    <h3>Publisher's Weekly</h3>
                    <p>Get the best writing and marketing tips delivered to your inbox.</p>
                    <form>
                        <input type="email" placeholder="Enter Your Email Address">
                        <button type="submit">Subscribe Now <i class="bi bi-arrow-right"></i></button>
                    </form>
                </div>
            </aside>

            <main class="amd-blog-detail-content">
                <p>
                    {!! $data['blog']->content ?? '' !!}
                </p>
            </main>
        </div>
        </div>
    </section>

@if ($data['blog']->related_blogs->count() > 0)
    <section class="amd-book-blog-section">
        <div class="amd-book-blog-container container">
            <!-- Section Header -->
            <header class="amd-book-blog-header">
                <div class="amd-book-section-header amd-book-section-header-flex">
                    <div>
                        <h2 class="amd-global-title-highlight">Related Blogs</h2>
                    </div>
                </div>
                @if($data['blog']->related_blogs->count() > 4)
                    <nav class="amd-book-blog-header-nav">
                        <button class="amd-book-blog-nav-arrow" aria-label="Previous Post">&larr;</button>
                        <button class="amd-book-blog-nav-arrow" aria-label="Next Post">&rarr;</button>
                    </nav>
                @endif
            </header>
            <!-- Blog Posts Grid -->
            <div class="amd-book-blog-grid">

                @foreach ($data['blog']->related_blogs as $item)
                    <article class="amd-book-blog-card">
                        <a href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? $item->id ?? '']) }}" class="amd-book-blog-card-link" aria-label="Blog Post', ['locale' => app()->getLocale()]) }}">
                            <img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                alt="{{ $item->title ?? '' }}" class="amd-book-blog-card-image">
                        </a>
                        <div class="amd-book-blog-card-body">
                            <p class="amd-book-blog-card-meta">{{ $item->created_at->format('M d, Y') }} • {{ $item->blogCategory->title ?? '' }}</p>
                            <h3 class="amd-book-blog-card-title">
                                <a href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? $item->id ?? '']) }}">{{ $item->title }}s</a>
                            </h3>
                            <a href="{{ route('site.blog.detail', ['locale' => app()->getLocale(), 'slug' => $item->slug ?? $item->id ?? '']) }}" class="amd-book-read-more-btn">Read more &rarr;</a>
                        </div>
                    </article>
                @endforeach


            </div>
            <!-- Footer Button -->
            <div class="text-end mt-3">
                <a href="{{ route('site.blog.list', ['locale' => app()->getLocale()]) }}" class="amd-book-view-all text-center">
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
        </div>
    </section>
@endif


@endsection
