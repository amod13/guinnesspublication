@extends('admin.main.app')
@section('content')
    {{-- Breadcrumb --}}
    <x-ui.breadcrumb :title="'Dealerss'" :items="[
        ['label' => isset($data['record']->id) ? 'Edit Dealers' : 'Create Dealers', 'url' => route('dealers.index')],
        ['label' => isset($data['record']->id) ? 'Edit Dealers' : 'Create Dealers', 'url' => '', 'active' => true],
    ]" />
    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('dealers.index')" :title="isset($data['record']->id) ? 'Edit Dealers' : 'Create Dealers'" />

        {{-- Form Section --}}
        <div class="card-body">
            <div class="p-4 border rounded">
                @include('publication::admin.dealers.partial._form')
            </div>
        </div>
    </div>

@endsection