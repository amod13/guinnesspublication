  </main>
  <!-- Footer Section -->

  <footer class="amd-book-footer">
      <!-- Decorative background image of book spines -->
      <img src="https://i.imgur.com/T0y3bSB.png" alt="Book spine decoration" class="amd-book-footer-decoration">

      <div class="container">
          <div class="row">
              <!-- Column 1: About & Socials -->
              <div class="col-lg-4 col-md-6 amd-book-footer-column amd-book-footer-about">
                  <p>
                      {{ $data['aboutTagline']->description ?? '' }}
                  </p>
                  <div class="amd-book-footer-social-icons">
                      @if ($data['setting']->facebook)
                          <a href="{{ $data['setting']->facebook }}" aria-label="Facebook" target="_blank"><i
                                  class="fab fa-facebook-f"></i></a>
                      @endif
                      @if ($data['setting']->twitter)
                          <a href="{{ $data['setting']->twitter }}" aria-label="Twitter" target="_blank"><i
                                  class="fab fa-twitter"></i></a>
                      @endif
                      @if ($data['setting']->instagram)
                          <a href="{{ $data['setting']->instagram }}" aria-label="Instagram" target="_blank"><i
                                  class="fab fa-instagram"></i></a>
                      @endif
                      @if ($data['setting']->youtube)
                          <a href="{{ $data['setting']->youtube }}" aria-label="youtube" target="_blank"><i
                                  class="fab fa-youtube"></i></a>
                      @endif
                  </div>
              </div>

              <!-- Column 2: Navigation Links -->
              <div class="col-lg-4 col-md-6 amd-book-footer-column amd-book-footer-links">
                  <h3>{{ __('site/title.quick_links') }}</h3>
                  <div class="row">
                      <div class="col-6 amd-book-footer-link-group">
                          <ul>
                              @foreach ($data['menus']->take(3) as $menu)
                                  <li><a
                                          href="{{ $menu->page_id ? route('get.single.page', ['locale' => request()->route('locale') ?? 'en', 'slug' => $menu->page->slug ?? $menu->page_id]) : ($menu->url ?: '#') }}">{{ $menu->title }}</a>
                                  </li>
                              @endforeach
                          </ul>
                      </div>

                  </div>
              </div>

              <!-- Column 3: Subscribe -->
              <div class="col-lg-4 col-md-12 amd-book-footer-column amd-book-footer-connect">
                  <h3>Stay Updated</h3>
                  <p>Subscribe to our newsletter for the latest book releases, author interviews, and special offers.
                  </p>
                  <form action="#">
                      <div class="input-group mt-3">
                          <input type="email" class="form-control" placeholder="your.email@example.com" required>
                          <button class="btn" type="submit" title="Subscribe"><i
                                  class="fas fa-paper-plane"></i></button>
                      </div>
                  </form>
              </div>
          </div>

          <!-- Footer Bottom Bar -->
          <div class="row">
              <div class="col-12 amd-book-footer-bottom">
                  <p class="text-white">&copy; {{ date('Y') }} {{ $data['setting']->site_name ?? '' }}. All Rights
                      Reserved.
                      <a href="https://amdsoft.com.np/" target="_blank">Powered By : A.M.D. Soft and Services
                          Pvt.Ltd.</a>
                  </p>
              </div>
          </div>
      </div>
  </footer>

  <!-- jQuery (Always First) -->
  <script src="{{ asset('site/assets/js/jquery-3.7.1.min.js') }}"></script>

  <!-- Bootstrap (Needs jQuery) -->
  <script src="{{ asset('site/assets/js/bootstrap.bundle.min.js') }}"></script>

  <!-- GSAP + Plugins -->
  <script src="{{ asset('site/assets/js/gsap.min.js') }}"></script>
  <script src="{{ asset('site/assets/js/ScrollTrigger.min.js') }}"></script>

  <!-- Swiper.js (Independent) -->
  <script src="{{ asset('site/assets/js/swiper-bundle.min.js') }}"></script>

  <!-- Slick.js (Needs jQuery) -->
  <script src="{{ asset('site/assets/js/slick.min.js') }}"></script>

  <!-- Lenis (Smooth Scroll, Independent but used with GSAP sometimes) -->
  <script src="{{ asset('site/assets/js/lenis.min.js') }}"></script>

  <!-- Custom Scripts (Always Last) -->
  <script src="{{ asset('site/assets/js/main.js') }}"></script>
  <script src="{{ asset('site/assets/js/animation.js') }}"></script> <!-- typo fix from aniamtion.js -->
  <script src="{{ asset('site/assets/js/editor.js') }}"></script> <!-- typo fix from aniamtion.js -->
  <script>
      $(document).ready(function() {
          // Initialize editor with advanced options
          $("#editor1").ranjitEditor({
              autosave: true,
              wordCount: true,
              darkMode: false,
              fullscreen: true,
              emoji: true
          });
      });
  </script>
  @stack('scripts')

  </body>

  </html>
