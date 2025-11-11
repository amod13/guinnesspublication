@extends('admin.main.app')
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="amd-profile-card-corporate__header">
                    <img src="{{ $data['book']->getMediaUrl('thumbnail_image') }}" alt="Rebecca Wason" class="amd-profile-card-corporate__avatar">
                    <div class="amd-profile-card-corporate__info">
                        <h3 class="amd-profile-card-corporate__name">Rebecca Wason</h3>
                        <p class="amd-profile-card-corporate__handle">@Rebecca Wason</p>
                        <p class="amd-profile-card-corporate__bio">Rebecca Wason brings peace to
                            your web browser</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
