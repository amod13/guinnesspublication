@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('about-us.index')" :title="isset($data['record']->id) ? 'Edit About Us' : 'Create About Us'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.aboutUs.partials._form')
            </div>
        </div>
    </div>
@endsection
