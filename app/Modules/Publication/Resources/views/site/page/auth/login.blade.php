    @extends('publication::site.page.auth.layouts')
    @section('content')
        {{-- Login Page --}}
        <div class="amd-book-page amd-book-page-1 active-page">
            <div class="page__front">
                <a href="{{ url('/') }}" class="amd-back-to-home" id="BackButton">Back<i class="fas fa-arrow-right"></i>
                </a>
                <h2 class="amd-book__form-title">Login</h2>
                <form action="{{ route('site.login.store', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ request('redirect_to') }}">
                    <div class="amd-book__form-field">
                        <input type="text" name="name" id="login-email" class="amd-book__input"
                            placeholder="username or email">
                        <label for="login-email" class="amd-book__label">Email Address/User Name</label>
                        <span class="text-danger">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-book__form-field">
                        <input type="password" name="password" id="login-pass" class="amd-book__input"
                            placeholder="Password">
                        <label for="login-pass" class="amd-book__label">Password</label>
                        <span class="amd-book__password-toggle"><i class="fas fa-eye"></i></span>
                           <span class="text-danger">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="amd-book__submit-btn">Login</button>
                </form>
                <div class="amd-book__form-links">
                    <span class="amd-link-account">Don't Have An Account</span>
                    <a href="{{ route('site.register.form', ['locale' => app()->getLocale()]) }}">Sign Up</a>
                </div>

                <div class="amd-book__social-login">

                    <div class="text-center mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <hr class="flex-grow-1" style="border-color: rgba(255,255,255,0.3);">
                            <span class="px-3 text-white-50">or continue with</span>
                            <hr class="flex-grow-1" style="border-color: rgba(255,255,255,0.3);">
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('site.auth.google', ['locale' => app()->getLocale(), 'redirect_to' => request('redirect_to')]) }}"
                                class="btn btn-outline-light flex-fill">
                                <i class="fab fa-google me-2"></i>Google
                            </a>
                            {{-- <a href="http://192.168.10.10:8001/auth/facebook"
                                    class="btn btn-outline-light flex-fill">
                                    <i class="fab fa-facebook-f me-2"></i>Facebook
                                </a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="page__back"></div>
        </div>
    @endsection
