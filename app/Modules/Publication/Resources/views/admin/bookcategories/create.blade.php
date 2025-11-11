@extends('admin.main.app')
@section('content')

    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('bookcategories.index')" :title="isset($data['record']->id) ? 'Edit BookCategories' : 'Create BookCategories'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-4 border rounded">
                @include('publication::admin.bookcategories.partial._form')
            </div>
        </div>
    </div>

@endsection