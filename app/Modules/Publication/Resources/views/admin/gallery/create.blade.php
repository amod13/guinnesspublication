@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('gallery.index')" :title="isset($data['record']->id) ? 'Edit Gallery' : 'Create Gallery'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.gallery.partials._form')
            </div>
        </div>
    </div>
@endsection
