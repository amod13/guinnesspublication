@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('books.index')" :title="isset($data['record']->id) ? 'Edit Book' : 'Create Book'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.books.partials._form')
            </div>
        </div>
    </div>
@endsection

