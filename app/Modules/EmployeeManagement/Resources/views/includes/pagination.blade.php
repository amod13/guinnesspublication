@if (!empty($data['records']) && $data['records']->total() > 0)
    <ul class="amd-pagination amd-pagination-elegant">

        {{-- Previous Page Link --}}
        @if ($data['records']->onFirstPage())
            <li class="amd-page-item disabled">
                <a class="amd-page-link"><i class="fas fa-chevron-left"></i></a>
            </li>
        @else
            <li class="amd-page-item">
                <a class="amd-page-link" href="{{ $data['records']->previousPageUrl() }}">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($data['records']->links()->elements[0] ?? [] as $page => $url)
            @if (is_string($page))
                <li class="amd-page-item amd-page-ellipsis"><span>{{ $page }}</span></li>
            @else
                <li class="amd-page-item {{ $page == $data['records']->currentPage() ? 'active' : '' }}">
                    <a class="amd-page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($data['records']->hasMorePages())
            <li class="amd-page-item">
                <a class="amd-page-link" href="{{ $data['records']->nextPageUrl() }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        @else
            <li class="amd-page-item disabled">
                <a class="amd-page-link"><i class="fas fa-chevron-right"></i></a>
            </li>
        @endif

    </ul>
@endif
