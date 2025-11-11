@extends('publication::site.main.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1>{{ $data['page']->title }}</h1>
            <div class="content">
                {!! $data['page']->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
