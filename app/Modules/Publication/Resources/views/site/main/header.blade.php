  <!-- nav bar  -->
  <header class="amd-header">
      <nav class="amd-navbar">
          <a href="{{ url('/') }}" class="amd-logo">
              <img src="{{ asset('uploads/images/site/' . $data['setting']->logo) }}"
                  alt="{{ $data['setting']->site_name ?? '' }}">
          </a>

          {{-- <ul class="amd-nav-links" id="amd-nav-menu">
              <li><a href="{{ route('home.index', ['locale' => request()->route('locale') ?? 'en']) }}"
                      class="active">{{ __('site/title.home') }}</a></li>
              @if (isset($data['menus']) && $data['menus']->count() > 0)
                  @foreach ($data['menus']->where('parent_id', null)->where('status', 1) as $menu)
                      @if ($menu->children && $menu->children->count() > 0)
                          <li class="amd-dropdown">
                              <a
                                  href="{{ $menu->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $menu->page->slug ?? $menu->page_id]) : ($menu->url ?: '#') }}">{{ $menu->title }}</a>
                              <ul class="amd-dropdown-menu">
                                  @foreach ($menu->children->where('status', 1) as $child)
                                      <li>
                                          <a
                                              href="{{ $child->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $child->page->slug ?? $child->page_id]) : ($child->url ?: '#') }}">{{ $child->title }}</a>
                                      </li>
                                  @endforeach
                              </ul>
                          </li>
                      @else
                          <li>
                              <a
                                  href="{{ $menu->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $menu->page->slug ?? $menu->page_id]) : ($menu->url ?: '#') }}">{{ $menu->title }}</a>
                          </li>
                      @endif
                  @endforeach
              @endif
          </ul> --}}

          <ul class="amd-nav-links" id="amd-nav-menu">

              <li>
                  <a href="{{ route('home.index', ['locale' => request()->route('locale') ?? 'en']) }}"
                      class="{{ request()->routeIs('home.index') ? 'active' : '' }}">
                      {{ __('site/title.home') }}
                  </a>
              </li>

              @if (isset($data['menus']) && $data['menus']->count() > 0)
                  @foreach ($data['menus']->where('parent_id', null)->where('status', 1) as $menu)
                      @php
                          $isActive = false;

                          // check parent menu
                          if (
                              $menu->page_id &&
                              request()->routeIs('get.single.page') &&
                              request()->route('slug') == ($menu->page->slug ?? $menu->page_id)
                          ) {
                              $isActive = true;
                          }

                          // check child menus
                          if ($menu->children && $menu->children->where('status', 1)->count() > 0) {
                              foreach ($menu->children as $child) {
                                  if (
                                      $child->page_id &&
                                      request()->routeIs('get.single.page') &&
                                      request()->route('slug') == ($child->page->slug ?? $child->page_id)
                                  ) {
                                      $isActive = true;
                                      break;
                                  }
                              }
                          }
                      @endphp

                      @if ($menu->children && $menu->children->count() > 0)
                          <li class="amd-dropdown {{ $isActive ? 'active' : '' }}">
                              <a
                                  href="{{ $menu->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $menu->page->slug ?? $menu->page_id]) : ($menu->url ?: '#') }}">
                                  {{ $menu->title }}
                              </a>
                              <ul class="amd-dropdown-menu">
                                  @foreach ($menu->children->where('status', 1) as $child)
                                      <li>
                                          <a href="{{ $child->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $child->page->slug ?? $child->page_id]) : ($child->url ?: '#') }}"
                                              class="{{ request()->routeIs('get.single.page') && request()->route('slug') == ($child->page->slug ?? $child->page_id) ? 'active' : '' }}">
                                              {{ $child->title }}
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                          </li>
                      @else
                          <li>
                              <a href="{{ $menu->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $menu->page->slug ?? $menu->page_id]) : ($menu->url ?: '#') }}"
                                  class="{{ $isActive ? 'active' : '' }}">
                                  {{ $menu->title }}
                              </a>
                          </li>
                      @endif
                  @endforeach
              @endif
              <li>
                  <a href="{{ route('site.contact.us', ['locale' => request()->route('locale') ?? 'en']) }}"
                      class="{{ request()->routeIs('site.contact.us') ? 'active' : '' }}">
                      Contact Us
                  </a>
              </li>
          </ul>


          <div class="amd-nav-actions">
              {{-- <div class="language-switcher">
                  <select class="form-select form-select-sm" style="width: auto; margin-right: 10px;"
                      onchange="window.location.href=this.value" aria-label="Language Switcher">
                      <option value="{{ route('switch.language', 'en') }}"
                          {{ request()->route('locale') == 'en' ? 'selected' : '' }}>English</option>
                      <option value="{{ route('switch.language', 'np') }}"
                          {{ request()->route('locale') == 'np' ? 'selected' : '' }}>नेपाली</option>
                  </select>
              </div> --}}
              <div class="auth">
                  @auth
                      <li class="list-unstyled dropdown amd-nav-links">
                          <a href="#" class="dropdown-toggle d-flex align-items-center" id="userDropdown"
                              role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-user me-1"></i> Logged in
                          </a>

                          <ul class="dropdown-menu amd-book-login-btn" style="border-radius: 0 !important;"
                              aria-labelledby="userDropdown">
                              <li>
                                  <a href="{{ route('site.user.profile', ['locale' => app()->getLocale()]) }}"
                                      class="dropdown-item">
                                      <i class="fas fa-id-badge me-2"></i> Profile
                                  </a>
                              </li>
                              <li>
                                  <form action="{{ route('site.logout', ['locale' => app()->getLocale()]) }}"
                                      method="POST" class="d-inline">
                                      @csrf
                                      <button type="submit" class="dropdown-item">
                                          <i class="fas fa-sign-out-alt me-2"></i> Log out
                                      </button>
                                  </form>
                              </li>

                          </ul>
                      </li>
                  @endauth

                  @guest
                      <li class="list-unstyled amd-nav-links">
                          <a href="{{ route('site.login.form', ['locale' => app()->getLocale(), 'redirect_to' => url()->current()]) }}"
                              class="d-flex align-items-center">
                              <i class="fas fa-user me-1"></i> Login
                          </a>
                      </li>
                  @endguest

              </div>





              <!-- 🔍 Search button -->
              <button class="amd-search-btn " id="amd-search-toggle" aria-label="Toggle Search">
                  <img src="{{ asset('site/assets/imgs/search empty (1).gif') }}" width="70" alt="">
              </button>

              {{-- information toggle --}}
              <button class="amd-info-toggle-btn" id="amd-info-toggle"
                  aria-label="Open Information Panel">&#8592;</button>

              {{-- Mobile Hamburger --}}
              <button class="amd-hamburger" id="amd-hamburger" aria-label="Toggle Menu">
                  <span class="amd-bar"></span>
                  <span class="amd-bar"></span>
                  <span class="amd-bar"></span>
              </button>

          </div>
      </nav>

      {{-- Search panel --}}
      <form action="{{ route('site.books.search', ['locale' => app()->getLocale()]) }}" method="POST">
          @csrf
          <div class="amd-search-bar" id="amd-search-bar">
              <input type="text" name="keyword" id="amd-search-input" placeholder="Search books, authors, genres..."
                  value="{{ request('keyword') }}">
              <span class="amd-clear" id="amd-clear">&times;</span>
              <button type="submit">Go</button>
          </div>
      </form>


      <!-- Overlay -->
      <div class="amd-overlay" id="amd-overlay"></div>

      <!-- Detail -->
      <div class="amd-info-canvas" id="amd-info-canvas">
          <button class="amd-close-canvas-btn" id="amd-close-canvas">&times;</button>

          @if (!empty($data['aboutTagline']->description))
              <h2>About Us</h2>
              <p>{{ $data['aboutTagline']->description }}</p>
          @endif
          <hr>
          @if (!empty($data['setting']->address))
              <h4>📍 Address</h4>
              <p>{{ $data['setting']->address }}</p>
          @endif
          <hr>
          <h4>📞 Contact</h4>

          @if (!empty($data['setting']->phone))
              <p><strong>Phone:</strong> {{ $data['setting']->phone }}</p>
          @endif

          @if (!empty($data['setting']->helpline))
              <p><strong>Support:</strong> {{ $data['setting']->helpline }}</p>
          @endif

          @if (!empty($data['setting']->email))
              <p><strong>Email:</strong> {{ $data['setting']->email }}</p>
          @endif
          <hr>

          @if (
              !empty($data['setting']->facebook) ||
                  !empty($data['setting']->instagram) ||
                  !empty($data['setting']->twitter) ||
                  !empty($data['setting']->youtube) ||
                  !empty($data['setting']->website))
              <h4>🌐 Social Media</h4>
              <ul class="social-list">

                  @if (!empty($data['setting']->facebook))
                      <li><a href="{{ $data['setting']->facebook }}" target="_blank">
                              <i class="bi bi-facebook"></i> Facebook
                          </a></li>
                  @endif

                  @if (!empty($data['setting']->instagram))
                      <li><a href="{{ $data['setting']->instagram }}" target="_blank">
                              <i class="bi bi-instagram"></i> Instagram
                          </a></li>
                  @endif

                  @if (!empty($data['setting']->twitter))
                      <li><a href="{{ $data['setting']->twitter }}" target="_blank">
                              <i class="bi bi-twitter-x"></i> Twitter
                          </a></li>
                  @endif

                  @if (!empty($data['setting']->youtube))
                      <li><a href="{{ $data['setting']->youtube }}" target="_blank">
                              <i class="bi bi-youtube"></i> YouTube
                          </a></li>
                  @endif

                  @if (!empty($data['setting']->website))
                      <li><a href="{{ $data['setting']->website }}" target="_blank">
                              <i class="bi bi-globe"></i> Website
                          </a></li>
                  @endif

              </ul>
          @endif

  </header>
