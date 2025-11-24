@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="{{ route('site.about.us', ['locale' => app()->getLocale()]) }}" class="breadcrumb-link-amd">{{ $data['about']->title ?? '' }}</a>
                </li>
            </ol>
        </nav>
    </section>


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



@endsection
