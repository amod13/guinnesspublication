@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('slider.index')" :title="isset($data['record']->id) ? 'Edit Slider' : 'Create Slider'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.slider.partials._form')
            </div>
        </div>
    </div>
@endsection
