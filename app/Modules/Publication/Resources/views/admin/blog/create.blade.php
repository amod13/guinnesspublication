@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('blog.index')" :title="isset($data['record']->id) ? 'Edit Blog' : 'Create Blog'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.blog.partials._form')
            </div>
        </div>
    </div>
@endsection
