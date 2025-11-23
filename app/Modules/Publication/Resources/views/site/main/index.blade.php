@extends('publication::site.main.app')
@section('content')

    <!-- Slider Section -->
    @if ($data['slider']->count() > 0)
        <section class="amd-hero">
            <div id="amdHeroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($data['slider'] as $item)
                        <div class="carousel-item active">
                            <div class="amd-hero-container">
                                <div class="amd-hero-content">
                                    <h1>
                                        {{ $item->title ?? '' }}
                                    </h1>
                                    <p class="book-description">
                                        {!! $item->description ?? '' !!}
                                    </p>
                                    <div class="amd-hero-buttons">
                                        <a href="#" class="amd-btn amd-btn-primary">Contact Us</a>
                                        <a href="#" class="amd-btn amd-btn-secondary">Browse Catalog</a>
                                    </div>
                                </div>
                                <div class="amd-hero-images">
                                    <!-- IMPORTANT: Replace these placeholder image URLs with your own book covers -->
                                    <img src="{{ $item->getMediaUrl('background_image') }}" alt="{{ $item->title ?? '' }}"
                                        class="amd-book amd-book-1">
                                    <img src="{{ $item->getMediaUrl('background_image_1') }}" alt="{{ $item->title ?? '' }}"
                                        class="amd-book amd-book-2">
                                    <img src="{{ $item->getMediaUrl('background_image_2') }}" alt="{{ $item->title ?? '' }}"
                                        class="amd-book amd-book-3">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Carousel Controls -->
                @if (count($data['slider']) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#amdHeroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#amdHeroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <!-- Carousel Indicators -->
                    <div class="carousel-indicators">
                        @foreach ($data['slider'] as $i => $item)
                            <button type="button" data-bs-target="#amdHeroCarousel" data-bs-slide-to="{{ $i }}"
                                class="{{ $i == 0 ? 'active' : '' }}" aria-current="{{ $i == 0 ? 'true' : '' }}"
                                aria-label="Slide {{ $i + 1 }}">
                            </button>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    {{-- About Us Page --}}
    @if (!empty($data['about']))
        <section class="amd-about-section ">
            <div class="container">
                <header class="amd-about-section-header">
                    <div class="amd-about-section-header-title">
                        <h2>{!! $data['about']->title ?? '' !!}</h2>
                    </div>
                    <div class="amd-about-section-header-squares"></div>
                </header>
                <div class="amd-about-section-grid">
                    <!-- Left Column -->
                    <div class="amd-about-section-image-main">
                        <img src="{{ $data['about']->getMediaUrl('image_media_id') }}" alt=" {!! $data['about']->title ?? '' !!}">
                    </div>
                    <!-- Right Column -->
                    <div class="amd-about-section-content">
                        <p>
                            {!! $data['about']->description ?? '' !!}
                        </p>
                        <div class="amd-about-section-content-footer">
                            <!-- SVG Badge -->
                            <div class="amd-about-section-badge">
                                <svg class="amd-about-section-badge-svg" viewBox="0 0 100 100">
                                    <defs>
                                        <path id="circlePath" d="M 50, 50 m -40, 0 a 40,40 0 1,1 80,0 a 40,40 0 1,1 -80,0">
                                        </path>
                                    </defs>
                                    <text font-family="Poppins, sans-serif" font-size="9" font-weight="700" fill="#212121">
                                        <textPath xlink:href="#circlePath">
                                            • SINCE 2001, LEADING DIGITAL AGENCY
                                        </textPath>
                                    </text>
                                    <circle cx="50" cy="50" r="25" fill="#c9fcc269"></circle>
                                    <g stroke="#212121" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        fill="none">
                                        <path d="M45 55 l10 -10"></path>
                                        <path d="M55 55 l0 -10 l-10 0"></path>
                                    </g>
                                </svg>
                            </div>
                            <!-- Small Image -->
                            <div class="amd-about-section-image-small">
                                <img src="../assets/imgs/Untitled design (11).png" accept="png,tif,jpg"
                                    alt="Two colleagues looking at a computer screen.">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mession vission goal section -->
            <!-- MVG Section -->
            <div class="amd-MGV-section-container">
                <div class="container">
                    <div class="amd-MGV-section-grid ">
                        <!-- Left Column: Intro Text -->
                        <div class="amd-MGV-section-intro">
                            <h2>Our Vision, Mission & Goals</h2>
                            <p>We are committed to creating a lasting impact through dedication, innovation, and purpose.
                                Our
                                direction is
                                guided by a clear vision, a strong mission, and focused goals that drive continuous growth
                                and
                                excellence.</p>
                        </div>

                        <!-- Right Column: Grid of Cards -->
                        <div class="amd-MGV-card-grid">

                            <!-- Vision -->
                            @foreach ($data['vmgs'] as $vmg)
                                <article class="amd-MGV-card">
                                    <div class="amd-MGV-card-icon">
                                        <i class="fa-solid fa-eye"></i>
                                    </div>
                                    <div class="amd-MGV-card-content">
                                        <h3>{{ $vmg->title }}</h3>
                                        @php
                                            $features = $vmg->features['features'] ?? [];
                                        @endphp
                                        @if (!empty($features))
                                            <ul class="amd-MGV-card-list">
                                                @foreach ($features as $feature)
                                                    <li>
                                                        <i class="fa-solid fa-square-check"></i> {{ $feature }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

        </section>
    @endif

    <!-- Classic Books Section -->
    @if ($data['bestSellingBooks']->count() > 0)
        <section class="amd-book-section">
            <div class="container">
                <div class="amd-book-section-bg-text">Classics</div>
                <div class="amd-book-section-header">
                    <h2 class="amd-global-title-highlight">Classics</h2>
                    <a href="#" class="amd-book-view-all">
                        <!-- From Uiverse.io by Li-Deheng -->
                        <button class="button">
                            <span>{{ __('site/title.view_all') }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 43">
                                <polygon points="39.58,4.46 44.11,0 66,21.5 44.11,43 39.58,38.54 56.94,21.5"></polygon>
                                <polygon points="19.79,4.46 24.32,0 46.21,21.5 24.32,43 19.79,38.54 37.15,21.5"></polygon>
                                <polygon points="0,4.46 4.53,0 26.42,21.5 4.53,43 0,38.54 17.36,21.5"></polygon>
                            </svg>
                        </button>

                    </a>

                </div>

                <div class="amd-book-section-carousel-wrapper">
                    <button class="amd-book-section-nav amd-book-section-nav-prev" aria-label="Previous"><i
                            class="fa-solid fa-chevron-left"></i></button>

                    <div class="amd-book-section-carousel">
                        <!-- Book Item 1 -->
                        @foreach ($data['bestSellingBooks'] as $item)
                            <a href="{{ route('single.book.detail', ['locale' => request()->route('locale') ?? 'en', 'slug' => $item->slug ?? $item->id]) }}"
                                class="amd-book-section-item">
                                <div class="amd-book-section-flipper">
                                    <div class="amd-book-section-flip-inner">
                                        <div class="amd-book-section-front">
                                            <img src="{{ $item->getMediaUrl('thumbnail_image') }}"
                                                alt="Book Cover: City of Ashes">
                                        </div>
                                    </div>
                                </div>
                                <div class="amd-book-section-info">
                                    <h3>{{ $item->title }}</h3>
                                    <p>by: Friedrich Wilhelm</p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <button class="amd-book-section-nav amd-book-section-nav-next" aria-label="Next"><i
                            class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
        </section>
    @endif


    <!-- category section -->
    @if ($data['activeBookCategories']->count() > 0)
        <section class="amd-category-section">
            <div class="container">
                <h2 class="amd-global-title-highlight">Explore Book Category</h2>
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
                    <div class="col">
                        <a href="{{ route('book.category.list', ['locale' => app()->getLocale()]) }}"
                            class="amd-category-card amd-category-see-all">
                            <div class="d-flex align-items-center">
                                <div class="amd-category-icon me-3">
                                    <img src="{{ asset('site/assets/imgs/arrow.gif') }}" alt="See All Categories"
                                        class="img-fluid">
                                </div>
                                <div class="amd-category-text">
                                    <strong class="mb-0">See all Categories</strong>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Our Authors --}}
    @if ($data['activeAuthors']->count() > 0)
        <section class="amd-book-authors-section">
            <div class="container">
                <div class="amd-book-section-header amd-book-section-header-flex">
                    <div>
                        <h2 class="amd-global-title-highlight">Ours Authors </h2>
                    </div>
                    <a href="{{ route('site.author.list', ['locale' => app()->getLocale()]) }}"
                        class="amd-book-view-all">
                        <!-- From Uiverse.io by Li-Deheng -->
                        <button class="button">
                            <span>View All</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 43">
                                <polygon points="39.58,4.46 44.11,0 66,21.5 44.11,43 39.58,38.54 56.94,21.5"></polygon>
                                <polygon points="19.79,4.46 24.32,0 46.21,21.5 24.32,43 19.79,38.54 37.15,21.5"></polygon>
                                <polygon points="0,4.46 4.53,0 26.42,21.5 4.53,43 0,38.54 17.36,21.5"></polygon>
                            </svg>
                        </button>
                    </a>
                </div>
                <!-- Swiper Container -->
                <div class="swiper amd-book-authors-slider">
                    <div class="swiper-wrapper">
                        @foreach ($data['activeAuthors'] as $author)
                            <div class="swiper-slide amd-book-author-card">
                                <img src="{{ $author->getMediaUrl('image') }}" alt="{{ $author->name }}"
                                    class="amd-book-author-image">
                                <h3 class="amd-book-author-name">{{ $author->name }}</h3>
                                @if ($author->total_books > 0)
                                    <p class="amd-book-author-books">
                                        {{ $author->total_books ?? '' }}
                                        Published Books</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <!-- Swiper Controls -->
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
    @endif


@endsection
