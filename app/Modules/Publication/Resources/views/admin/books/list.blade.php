@extends('admin.main.app')
@section('content')
    <div class="row">
        @foreach ($data['books'] as $item)
            <div class="col-xl-4 col-md-6 d-flex justify-content-center mt-4">
                <div class="amd-profile-card-dark-moody">
                    <img class="amd-profile-card-dark-moody__bg-img" src="{{ $item->getMediaUrl('thumbnail_image') }}"
                        alt="{{ $item->title }}">
                    <div class="amd-profile-card-dark-moody__overlay">
                        <h3 class="amd-profile-card-dark-moody__name text-white">
                            <span class="amd-profile-card-dark-moody__verified"><i class="bi bi-check"></i></span>
                        </h3>
                        <p class="amd-profile-card-dark-moody__bio">
                            {{ $item->title }}
                        </p>
                        <div class="amd-profile-card-dark-moody__footer">
                            <a href="{{ route('books.detail', $item->id) }}" class="btn amd-btn-liquid-fill amd-btm-sm">Read More <i class="bi bi-plus"></i>
                                <span class="amd-liquid-wave"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
