@extends('admin.main.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-dark fw-bold">
                                {{ isset($data['record']->id) ? 'Edit Author' : 'Create New Author' }}
                            </h4>
                            <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @include('publication::admin.authors.partial._form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
