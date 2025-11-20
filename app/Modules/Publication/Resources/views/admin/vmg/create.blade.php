@extends('admin.main.app')
@section('content')
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('vmg.index')" :title="isset($data['record']->id) ? 'Edit VMG' : 'Create VMG'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-5 border rounded">
                @include('publication::admin.vmg.partials._form')
            </div>
        </div>
    </div>
@endsection
