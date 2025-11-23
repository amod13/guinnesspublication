@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="{{ route('site.author.list', ['locale' => app()->getLocale()]) }}" class="breadcrumb-link-amd">Author List</a>
                </li>
            </ol>
        </nav>
    </section>

    <!-- Favorite Authors Section -->
    <section class="amd-book-authors-section">
        <div class="container">

            <!-- author container -->
            <div class="d-flex flex-wrap gap-4">
                @foreach ($data['activeAuthors'] as $author)
                    <div class="swiper-slide amd-book-author-card ">
                        <img src="{{ $author->getMediaUrl('image') }}" alt="{{ $author->name }}" alt="Jane Austen">
                        <h3 class="amd-book-author-name">{{ $author->name }}</h3>
                        @if ($author->total_books > 0)
                            <p class="amd-book-author-books">
                                {{ $author->total_books ?? '' }}
                                Published Books</p>
                        @endif
                    </div>
                @endforeach
            </div>
               @include('publication::site.page.pagination.pagination', [
                    'paginator' => $data['activeAuthors'],
                ])

        </div>
    </section>

@endsection
