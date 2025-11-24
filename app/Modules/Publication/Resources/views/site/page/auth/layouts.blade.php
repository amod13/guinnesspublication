<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('site/assets/css/login.css') }}">
</head>

<body>
    <div class="amd-book-wrapper">
        <div class="amd-book" id="book">
            <div class="amd-book__spine"></div>
            <!-- Cover -->
            <div class="amd-book__cover amd-book__part">
                <div class="amd-book__cover-content">
                    <h1 class="amd-book__cover-title">The Publisher's Desk</h1>
                    <button class="amd-book__open-button" id="open-book-btn">Open Book</button>
                </div>
            </div>
    

             @yield('content')



            <!-- Static Left Page -->
            <div class="amd-book-page amd-book-page-4 amd-book__part"></div>

        </div>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const book = document.getElementById('book');
            const openBookBtn = document.getElementById('open-book-btn');
            const navLinks = document.querySelectorAll('.nav-link');
            const passwordToggles = document.querySelectorAll('.amd-book__password-toggle');
            const allPages = document.querySelectorAll('.amd-book-page');
            const isMobile = () => window.innerWidth <= 850;

            // --- Mobile Height Adjustment Function ---
            const adjustMobileHeight = () => {
                if (isMobile()) {
                    const activePage = document.querySelector('.active-page');
                    if (activePage) {
                        book.style.height = `${activePage.offsetHeight}px`;
                    }
                } else {
                    book.style.height = '600px'; // Reset to desktop height
                }
            };

            const showMobilePage = (target) => {
                let targetPage;
                if (target === 'login') targetPage = document.querySelector('.amd-book-page-1');
                else if (target === 'register') targetPage = document.querySelector('.amd-book-page-2');
                else if (target === 'forgot') targetPage = document.querySelector('.amd-book-page-3');

                if (targetPage) {
                    allPages.forEach(page => page.classList.remove('active-page'));
                    targetPage.classList.add('active-page');
                    adjustMobileHeight();
                }
            };

            openBookBtn.addEventListener('click', () => {
                if (isMobile()) return; // Button does nothing on mobile
                book.classList.add('is-open');
            });

            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = link.getAttribute('data-flip');

                    if (isMobile()) {
                        showMobilePage(target);
                        return;
                    }

                    book.classList.remove('flip-page-1', 'flip-page-2', 'flip-page-3');

                    if (target === 'register') book.classList.add('flip-page-1');
                    else if (target === 'forgot') book.classList.add('flip-page-2');
                });
            });

            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', () => {
                    const input = toggle.parentElement.querySelector('input');
                    const icon = toggle.querySelector('i');
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });

            // Initial setup on load
            if (isMobile()) {
                book.classList.remove('is-open');
                showMobilePage('login'); // Start on login page for mobile
            }
            window.addEventListener('resize', adjustMobileHeight);
        });
    </script>
</body>

</html>
