  <!-- nav bar  -->
  <header class="amd-header">
      <nav class="amd-navbar">
          <a href="{{ url('/') }}" class="amd-logo">
              <img src="{{ asset('uploads/images/site/' . $data['setting']->logo ) }}" alt="{{$data['setting']->site_name ?? ''}}">
          </a>

          <ul class="amd-nav-links" id="amd-nav-menu">
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
          </ul>

          <div class="amd-nav-actions">
              <!-- Language Switcher -->
              <div class="language-switcher">
                  <select class="form-select form-select-sm" style="width: auto; margin-right: 10px;"
                      onchange="window.location.href=this.value" aria-label="Language Switcher">
                      <option value="{{ route('switch.language', 'en') }}"
                          {{ request()->route('locale') == 'en' ? 'selected' : '' }}>English</option>
                      <option value="{{ route('switch.language', 'np') }}"
                          {{ request()->route('locale') == 'np' ? 'selected' : '' }}>नेपाली</option>
                  </select>
              </div>

              <!-- 🔍 Search button -->
              <button class="amd-search-btn " id="amd-search-toggle" aria-label="Toggle Search"><img
                      src="../assets/imgs/search empty (1).gif" width="70" alt=""></button>

              <button class="amd-hamburger" id="amd-hamburger" aria-label="Toggle Menu">
                  <span class="amd-bar"></span><span class="amd-bar"></span><span class="amd-bar"></span>
              </button>
          </div>
      </nav>

      <div class="amd-search-bar" id="amd-search-bar">
          <input type="text" id="amd-search-input" placeholder="Search books, authors, genres...">
          <span class="amd-clear" id="amd-clear">&times;</span>
          <button type="submit">Go</button>
      </div>

  </header>
