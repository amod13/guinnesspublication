@extends('publication::site.main.app')

@section('content')

<style>
    .password-wrap {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
    opacity: 0.7;
}
.toggle-password:hover {
    opacity: 1;
}

</style>
    <section class="amd-book-profile-container">
        {{-- Sidebar --}}
        @include('publication::site.page.userDashboard.partial.sidebar')
        <div class="amd-book-profile__content">
            <div id="profile-details" class="amd-book-tab-pane active">
                <h2 class="amd-book-pane__title">Profile Edit</h2>
                <form class="amd-book-profile-form" action="{{ route('site.user.profile.update', ['locale' => request()->route('locale') ?? 'en', 'id' => $data['userDetail']->id,]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="amd-book-profile__avatar-wrapper">
                        <img src="{{ asset('storage/profile_images/' . $data['userDetail']->profile_image  ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7PIVl6sCfi3RNfHTgtLC6gKZF8JBhaJwUog&s' ) }}" alt="{{ $data['userDetail']->full_name ?? $data['userDetail']->name}}" class="amd-book-profile__avatar"
                            id="avatar-preview">
                        <label for="avatar-upload-input" class="amd-book-profile__avatar-upload">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="avatar-upload-input" name="profile_image" accept="image/*">
                    </div>

                    <div class="amd-book-form-field">
                        <input type="text" name="full_name" id="full-name" class="amd-book-input"
                            value="{{ $data['userDetail']->full_name ?? '' }}" placeholder="Full Name">
                        <label for="full-name" class="amd-book-label">Full Name</label>
                    </div>

                    <div class="amd-book-form-field">
                        <input type="text" id="username" name="name" class="amd-book-input"
                            value="{{ $data['userDetail']->name ?? '' }}" placeholder="Username">
                        <label for="username" class="amd-book-label">Username</label>
                    </div>

                    <div class="amd-book-form-field">
                        <input type="email" id="username" name="email" class="amd-book-input"
                            value="{{ $data['userDetail']->email ?? '' }}" placeholder="example@gmail.com">
                        <label for="username" class="amd-book-label">Email</label>
                    </div>

                    <div class="amd-book-form-field password-wrap">
                        <input type="password" id="password" name="password" class="amd-book-input" placeholder="Password">
                        <label for="password" class="amd-book-label">Password</label>
                        <span class="toggle-password" onclick="togglePassword('password', this)">👁️</span>
                    </div>

                    <div class="amd-book-form-field password-wrap">
                        <input type="password" id="confirm_password" name="password_confirmation" class="amd-book-input"
                            placeholder="Confirm Password">
                        <label for="confirm_password" class="amd-book-label">Confirm Password</label>
                        <span class="toggle-password" onclick="togglePassword('confirm_password', this)">👁️</span>
                    </div>

                    <div class="amd-book-profile__action-buttons">
                        <button type="submit" class="edit-btn">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
                icon.textContent = "🙈"; // hide icon
            } else {
                input.type = "password";
                icon.textContent = "👁️"; // show icon
            }
        }
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const avatarUploadInput = document.getElementById('avatar-upload-input');
    const avatarPreview = document.getElementById('avatar-preview');

    avatarUploadInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                avatarPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

@endpush
