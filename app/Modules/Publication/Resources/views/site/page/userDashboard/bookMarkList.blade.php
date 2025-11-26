@extends('publication::site.main.app')

@section('content')
    <section class="amd-book-profile-container">
        {{-- Sidebar --}}
        @include('publication::site.page.userDashboard.partial.sidebar')

        {{-- BookMark Content --}}
        <div class="amd-book-profile__content">
            <div id="saved-books" class="amd-book-tab-pane active">
                <h2 class="amd-book-pane__title">Saved Books</h2>
                @if ($data['bookmarks']->count() > 0)
                    <ul class="amd-saved-books-list">
                        @foreach ($data['bookmarks'] as $item)
                            <li class="amd-saved-book-item">
                                <a href="{{ route('single.book.detail', ['locale' => request()->route('locale') ?? 'en', 'slug' => $item->slug ?? $item->id]) }}"
                                    class="amd-saved-book-link">
                                    <img src="{{ $item->getMediaUrl('thumbnail_image') }}" alt="Book Cover"
                                        class="amd-saved-book-cover">
                                    <div class="amd-saved-book-info">
                                        <div class="amd-saved-book-meta">
                                            <span class="amd-saved-book-date">Saved on
                                                {{ $item->favourite->first()->pivot->created_at->format('d M Y') }}</span>
                                        </div>
                                        <h3 class="amd-saved-book-title">{{ $item->title }}</h3>
                                        @if (!empty($item->author->name))
                                            <p class="amd-saved-book-author">by {{ $item->author->name ?? '' }}</p>
                                        @endif
                                        <div class="amd-book-genre-tags">
                                            <span class="amd-book-genre-tag"
                                                style="background-color: #e3e1fc; color: #4D47C3;">{{ $item->category->name ?? '' }}</span>
                                        </div>
                                    </div>
                                </a>
                                <button class="amd-book-bookmark-btn active" aria-label="Unsave this book">
                                    <i class="bi bi-bookmark-fill" data-book-id="{{ $item->id }}" id="bookMarkBook"></i>
                                </button>

                            </li>
                        @endforeach
                    </ul>
                    @include('publication::site.page.pagination.pagination', [
                        'paginator' => $data['bookmarks'],
                    ])
                @else
                    <div class="amd-no-category-container">
                        <div class="amd-no-category-card">
                            <div class="amd-no-category-page-shadow"></div>
                            <p>You haven’t saved any books yet.</p>
                            <div class="amd-book-profile__action-buttons text-center btn-sm">
                                <a href="{{ route('site.book.list', ['locale' => app()->getLocale()]) }}" class="edit-btn">
                                    Back To List
                                </a>
                            </div>
                        </div>
                    </div>
                @endif



            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#bookMarkBook').on('click', function() {
                debugger;
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
                        if (response.status === 'removed') {
                            window.location.reload();
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
