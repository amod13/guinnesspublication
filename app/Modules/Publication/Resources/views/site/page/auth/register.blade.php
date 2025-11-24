    @extends('publication::site.page.auth.layouts')
    @section('content')
        <style>
            .text-danger {
                color: red;
            }
        </style>
        <!-- Register Page -->
        <div class="amd-book-page amd-book-page-2">
            <div class="page__front">
                <a href="{{ url('/') }}" class="amd-back-to-home" id="BackButton">Back<i class="fas fa-arrow-right"></i>
                </a>
                <h2 class="amd-book__form-title">Create Account</h2>
                <form action="{{ route('site.register', ['locale' => app()->getLocale()]) }}" method="POST"
                    id="registerForm">
                    @csrf
                    <div class="amd-book__form-field">
                        <input type="text" name="name" value="{{ old('name') }}" id="reg-name"
                            class="amd-book__input" placeholder="Full Name">
                        <label for="reg-name" class="amd-book__label">User Name</label>
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-book__form-field">
                        <input type="email" id="reg-email" value="{{ old('email') }}" name="email"
                            class="amd-book__input" placeholder="Email">
                        <label for="reg-email" class="amd-book__label">Email Address</label>
                        <span class="text-danger">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-book__form-field">
                        <input type="password" id="reg-pass" name="password" class="amd-book__input"
                            placeholder="Password">
                        <label for="reg-pass" class="amd-book__label">Password</label>
                        <span class="amd-book__password-toggle"><i class="fas fa-eye"></i></span>
                    </div>
                    <div class="amd-book__form-field">
                        <input type="password" name="password_confirmation" id="reg-pass" class="amd-book__input"
                            placeholder="Password">
                        <label for="reg-pass" class="amd-book__label">Confirm Password</label>
                        <span class="amd-book__password-toggle"><i class="fas fa-eye"></i></span>
                        <span class="text-danger">
                            @error('password_confirmation')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="amd-book__submit-btn">Create</button>
                </form>
                <div class="amd-book__form-links">
                    <span class="amd-link-account">ALready Have An Account</span>
                    <a href="{{ route('site.login.form', ['locale' => app()->getLocale()]) }}" class="semi-bold">Back to
                        Login</a>
                </div>
            </div>
            <div class="page__back"></div>
        </div>
    @endsection
