@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">{{ $data['categoryDetail']->name ?? '' }}</a>
                </li>
            </ol>
        </nav>
    </section>

    <!-- category detail -->
    <section class="container-fluid  amd-category-detail-conatiner">
        <div class="row g-4 container amd-category-detail-wrapper">
            <!-- Left Sticky Sidebar Column -->
            <aside class="col-lg-3 p-0 amd-category-detail-sidebar d-none d-lg-block">
                <div class="amd-category-detail-sidebar-wrapper">
                    <nav class="nav amd-category-detail-sidebar-nav flex-column">
                        <div class="amd-category-detail-nav-heading mb-3 active">{{ $data['categoryDetail']->name ?? '' }}</div>
                        @foreach ($data['categoryDetail']->childrenRecursive as $parent)
                            <div class="amd-category-detail-nav-wrapper mt-1">
                                <a href="{{ route('book.list.by.category', ['locale' => app()->getLocale(), 'slug' => $parent->slug]) }}">
                                    <div class="amd-category-detail-sub-nav ">{{ $parent->name }}</div>
                                    <div class="gap-2 amd-category-detail-list">
                                        @if (!empty($parent->childrenRecursive))
                                            @foreach ($parent->childrenRecursive as $child)
                                                <a class="nav-link"
                                                    href="{{ route('book.list.by.category', ['locale' => app()->getLocale(), 'slug' => $child->slug]) }}">
                                                    <span
                                                        class="amd-category-detail-chapter-number">{{ $loop->iteration }}.</span>
                                                    <span>{{ $child->name }}</span>
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </nav>
                </div>
            </aside>


            <!-- Right Main Content Column -->
            <div class="col-lg-9 amd-category-detail-content">
                <div class="d-flex justify-content-end ">
                    <button class="amd-float-btn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#amdMobileCanvas">
                        <i class="fas fa-list me-2"></i>Open Lists
                    </button>
                </div>
                <article class="amd-category-detail-content-main">
                    <!-- this for the canvas open btn and in desktop hide and in mobile open -->

                    <div class="amd-category-detail-body-wrapper">
                        <div class="amd-category-detail-body">
                            <p class="lead">
                                {!! $data['categoryDetail']->content ?? '' !!}
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- Mobile Canvas -->
        <div class="offcanvas offcanvas-start amd-mobile-canvas" tabindex="-1" id="amdMobileCanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Contents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body" id="amd-mobile-canvas-content">
                {{-- <!-- Left Sticky Sidebar Column  comes here--> --}}
            </div>
        </div>

    </section>
@endsection
