@extends('admin.main.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-dark fw-bold">
                                Author Details
                            </h4>
                            <a href="{{ route('authors.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">

                        {{-- START: Author Details Content --}}
                        <div class="row">
                            {{-- Author Image (Optional) --}}
                            <div class="col-md-3 text-center mb-4">
                                <div class="p-3 border rounded">
                                    {{-- NOTE: Update the image path as per your setup --}}
                                    @if($data['record']->image)
                                        <img src="{{ $data['record']->getMediaUrl('image') }}"
                                             alt="{{ $data['record']->name }}"
                                             class="img-fluid rounded-circle mb-3"
                                             style="max-width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <div class="text-muted py-5 border rounded-circle" style="max-width: 150px; height: 150px; margin: 0 auto;">
                                            <i class="fas fa-user-circle fa-5x"></i>
                                            <p class="small mt-2">No Image</p>
                                        </div>
                                    @endif
                                    <h5 class="mt-3 fw-bold">{{ $data['record']->name }}</h5>
                                    <span class="badge bg-{{ $data['record']->status === 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($data['record']->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Author Data List --}}
                            <div class="col-md-9">
                                <h5 class="border-bottom pb-2 mb-4 text-primary">General Information</h5>

                                <dl class="row mb-0">
                                    {{-- Row 1: ID and Name --}}
                                    <dt class="col-sm-3 text-dark">ID:</dt>
                                    <dd class="col-sm-9">{{ $data['record']->id }}</dd>

                                    <dt class="col-sm-3 text-dark">Name:</dt>
                                    <dd class="col-sm-9 fw-bold">{{ $data['record']->name }}</dd>

                                    {{-- Row 2: Slug and Email --}}
                                    <dt class="col-sm-3 text-dark">Slug:</dt>
                                    <dd class="col-sm-9"><code>{{ $data['record']->slug }}</code></dd>

                                    <dt class="col-sm-3 text-dark">Email:</dt>
                                    <dd class="col-sm-9">
                                        <a href="mailto:{{ $data['record']->email }}">{{ $data['record']->email }}</a>
                                    </dd>

                                    {{-- Row 3: Address and Language --}}
                                    <dt class="col-sm-3 text-dark">Address:</dt>
                                    <dd class="col-sm-9">{{ $data['record']->address ?? 'N/A' }}</dd>

                                    <dt class="col-sm-3 text-dark">Language:</dt>
                                    <dd class="col-sm-9">{{ strtoupper($data['record']->language) }}</dd>
                                </dl>

                                <h5 class="border-bottom pb-2 mt-4 mb-4 text-primary">System Information</h5>

                                <dl class="row">
                                    <dt class="col-sm-3 text-dark">Display Order:</dt>
                                    <dd class="col-sm-9">{{ $data['record']->display_order ?? 'N/A' }}</dd>

                                    <dt class="col-sm-3 text-dark">Created At:</dt>
                                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($data['record']->created_at)->format('M d, Y h:i A') }}</dd>

                                    <dt class="col-sm-3 text-dark">Last Updated:</dt>
                                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($data['record']->updated_at)->format('M d, Y h:i A') }}</dd>
                                </dl>

                                @if($data['record']->content)
                                    <h5 class="border-bottom pb-2 mt-4 mb-4 text-primary">Author Bio / Content</h5>
                                    <div class="card p-3 bg-light">
                                        {!! $data['record']->content !!} {{-- Use {!! !!} if content includes HTML --}}
                                    </div>
                                @endif

                                <div class="mt-4 pt-2 border-top">
                                    <a href="{{ route('authors.edit', $data['record']->id) }}" class="btn btn-primary me-2">
                                        <i class="fas fa-edit me-1"></i> Edit Author
                                    </a>
                                    {{-- Delete button implementation (using a form for POST request) --}}
                                    <form action="{{ route('authors.destroy', $data['record']->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        {{-- END: Author Details Content --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
