@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('blog-category.index')" :title="isset($data['record']->id) ? 'Edit Blog Category' : 'Create Blog Category'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.blogCategory.partials._form')
            </div>
        </div>
    </div>
@endsection
