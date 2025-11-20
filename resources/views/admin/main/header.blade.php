<div class="amd-topbar">

    <div class="d-flex align-items-center ms-2">
        <i class="fas fa-bars amd-toggle-btn" id="toggleSidebar"></i>
        <a href="{{ url('/') }}" target="__blank" class="text-decoration-none text-dark"><span class="amd-page-title">View Site</span></a>
    </div>


    <div class="amd-top-icons">
        <form action="{{ route('set.language') }}" method="POST" id="languageForm">
            @csrf
            <!-- Language Switcher -->
            <select name="language" id="languageSelect" class="form-select form-select-sm" style="width: auto;"
            onchange="document.getElementById('languageForm').submit();"
                aria-label="Language Switcher">
                <option value="en" {{ session('language') == 'en' ? 'selected' : '' }}>EN</option>
                <option value="np" {{ session('language') == 'np' ? 'selected' : '' }}>NEP</option>
            </select>
        </form>


        <!-- Profile -->
        <div class="amd-profile-section">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                @if (Auth::user()->profile_image_url ?? '')
                    <img src="{{ Auth::user()->profile_image_url ?? null }}" alt="{{ Auth::user()->full_name ?? Auth::user()->name }}"
                        class="amd-profile-imgs rounded-circle me-2" width="36" height="36">
                @elseif(Auth::user()->avatar)
                    <img src="{{ Auth::user()->avatar }}"
                        alt="{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}" class="amd-profile-imgs rounded-circle me-2" width="36"
                        height="36">
                        @else
                              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->full_name ?? Auth::user()->name ?? '') }}&background=random"
                        alt="{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}" class="amd-profile-imgs rounded-circle me-2" width="36"
                        height="36">

                @endif
                <span>{{ Auth::user()->full_name ?? Auth::user()->name ?? '' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item 2" href="{{ route('user.profile') }}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#"
                        onclick="document.getElementById('logout-form').submit();">Logout</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>

    </div>

</div>
