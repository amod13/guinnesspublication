@extends('admin.main.app')
@section('content')
    {{-- Breadcrumb --}}
    <x-ui.breadcrumb :title="'Marketingss'" :items="[
        ['label' => isset($data['record']->id) ? 'Edit Marketings' : 'Create Marketings', 'url' => route('marketings.index')],
        ['label' => isset($data['record']->id) ? 'Edit Marketings' : 'Create Marketings', 'url' => '', 'active' => true],
    ]" />
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('marketings.index')" :title="isset($data['record']->id) ? 'Edit Marketings' : 'Create Marketings'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-4 border rounded">
                @include('publication::admin.marketings.partial._form')
            </div>
        </div>
    </div>

@endsection
