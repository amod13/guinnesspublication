@extends('admin.main.app')
@section('content')
    {{-- Breadcrumb --}}
    <x-ui.breadcrumb :title="'Dealerss'" :items="[
        ['label' => 'Dealers List', 'url' => route('dealers.index')],
        ['label' => 'View Dealers', 'url' => '', 'active' => true],
    ]" />

    <div class="card">
        {{-- Page Header --}}
        <x-ui.page-header :backRoute="route('dealers.index')" :title="'View Dealers'" />

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Name:</h5>
                    <p>{{ $data['record']->name }}</p>
                </div>
                <div class="col-md-6">
                    <h5>Status:</h5>
                    <x-table.status-badge :status="$data['record']->status" />
                </div>
            </div>
        </div>
    </div>

@endsection