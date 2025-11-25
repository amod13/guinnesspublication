@extends('publication::site.main.app')

@section('content')
    <section class="amd-book-profile-container">
        {{-- Sidebar --}}
        @include('publication::site.page.userDashboard.partial.sidebar')

        <div class="amd-book-profile__content">
            <!-- Profile Details Pane -->
            <div class="amd-book-tab-pane active">
                <h2 class="amd-book-pane__title">User Profile</h2>
                <div class="amd-book-profile-form">
                    <div class="amd-book-form-field">
                        <span class="amd-book-input">{{ $data['userDetail']->full_name ?? $data['userDetail']->name }}</span>
                        <label for="full-name" class="amd-book-label">Full Name</label>
                    </div>
                    <div class="amd-book-form-field">
                        <span class="amd-book-input">{{ $data['userDetail']->email ?? '' }}</span>
                        <label for="username" class="amd-book-label">Email</label>
                    </div>
                    <div class="amd-book-profile__action-buttons">
                        <a href="{{ route('site.user.profile.edit', ['locale' => request()->route('locale') ?? 'en', 'id' => $data['userDetail']->id,]) }}"
                            class="edit-btn">
                            Edit Profile
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
