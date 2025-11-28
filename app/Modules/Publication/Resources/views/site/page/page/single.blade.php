@extends('publication::site.main.app')

@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">{{ $data['page']->title ?? '' }}</a>
                </li>
            </ol>
        </nav>
    </section>

    <section class="amd-editor-content-container">
        <div class="container">
            <main class="amd-editor-content">
                {!! $data['page']->content !!}
            </main>
        </div>
    </section>
@endsection
