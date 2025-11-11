@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('page.index')" :title="isset($data['record']->id) ? 'Edit Page' : 'Create Page'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.page.partials._form')
            </div>
        </div>
    </div>
@endsection
