@extends('publication::site.main.app')
@section('content')

    <section class="amd-breadcrumb-section">
            <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
                <ol class="breadcrumb-list-amd">
                    <li class="breadcrumb-item-amd">
                        <a href="#" class="breadcrumb-link-amd">Home</a>
                    </li>
                    <li class="breadcrumb-item-amd">
                        <a href="#" class="breadcrumb-link-amd">Catalogue</a>
                    </li>
                    <li class="breadcrumb-item-amd">
                        <a href="#" class="breadcrumb-link-amd">Classic Literature</a>
                    </li>
                    <li class="breadcrumb-item-amd">
                        <span class="breadcrumb-current-amd" aria-current="page">Creative Nepali Grammer</span>
                    </li>
                </ol>
            </nav>
        </section>

        <section class="amd-flipbook-section" style="visibility:hidden; height:0;  transition: height 0.3s ease;">


            <div class="flipbook-container">
                <!-- Your entire flipbook markup here, e.g.: -->


                <!-- Flipbook Wrapper -->
                <div class="flipbook-wrapper">
                    <div class="flipbook-head container">
                        <div
                            class="amd-book-detail-page-right-content row align-items-center justify-content-between gap-3 text-center text-md-start">

                            <!-- Back Button in Column -->
                            <div class="col-auto">
                                <a href="book-detail.html">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>

                            <!-- Book Info in Column -->
                            <div class="col amd-3d-flipbook-head">
                                <div class="amd-book-title-group">
                                    <h1 class="amd-book-detail-page-title">
                                        <strong>Harry Potter:</strong>
                                        <span>Half Blood Prince</span>
                                    </h1>
                                    <p class="amd-book-detail-page-author">by J.K. Rowling</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Loader -->
                    <div id="loader">
                        <div class="spinner"></div>
                        <p id="loader-text">Loading PDF...</p>
                    </div>

                    <!-- Flipbook Container -->
                    <div id="flipbook" class="flipbook"></div>

                    <!-- Hidden PDF Source -->
                    <iframe src="https://ontheline.trincoll.edu/images/bookdown/sample-local-pdf.pdf"
                        style="display:none;" aria-hidden="true"></iframe>
                </div>


                <!-- Flipbook Controls -->
                <div class="flipbook-controls">
                    <button id="zoomIn" title="Zoom In"><i class="bi bi-zoom-in"></i></button>
                    <button id="zoomOut" title="Zoom Out"><i class="bi bi-zoom-out"></i></button>
                    <button id="fullscreen" title="Fullscreen"><i class="bi bi-fullscreen"></i></button>
                </div>
            </div>
        </section>

        <section class="amd-book-detail-page-wrapper container">
            <!-- Using a single container for logical flow -->
            <div class="row align-items-center g-4 g-lg-5" id="bookPart">
                <!-- Left Column (Image) - Stacks on top on mobile -->
                <div class="col-md-5 text-center text-md-start">
                    <div class="amd-book-detail-page-cover">
                        <!-- Replaced with a working placeholder image -->
                        <img src="../assets/imgs/GK.png" alt="Harry Potter Book Cover"
                            class="amd-book-detail-page-cover-img d-block" />
                    </div>
                </div>

                <!-- Right Column (Title/Author) - Stacks below image on mobile -->
                <div class="col-md-7 text-center text-md-start amd-book-detail-page-right-content">
                    <h1 class="amd-book-detail-page-title">Harry Potter: Half Blood Prince</h1>
                    <p class="amd-book-detail-page-author">by JK Rowling</p>
                    <p class="amd-book-detail-page-summary mx-auto mx-md-0" style="max-width: 450px;">
                        Get ready to uncover the dark secrets and betrayals in the book. A thrilling adventure awaits
                        you.
                    </p>
                </div>
            </div>



            <!-- Full-width Info Card - Sits below the content above -->
            <div class="row">
                <div class="col-12">
                    <div class="amd-book-detail-page-info-card">
                        <!-- Actions Row -->
                        <div class="d-flex justify-content-center justify-content-md-end">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 amd-book-detail-page-actions w-100"
                                style="max-width: 360px;">

                                <!-- Start Reading Button -->
                                <button type="button" class="amd-book-read-more-btn " id="startReadingPdf">
                                    Start reading <i class="bi bi-arrow-right"></i>
                                </button>

                                <!-- Icon Group -->
                                <div class="amd-book-detail-page-icon-group position-relative">
                                    <i class="bi bi-bookmark"></i>

                                    <!-- Share Icon with Dropdown -->
                                    <div class="dropdown d-inline-block">
                                        <i class="bi bi-share" id="shareDropdown" data-bs-toggle="dropdown"
                                            aria-expanded="false" role="button"></i>

                                        <!-- Smooth Dropdown -->
                                        <ul class="dropdown-menu dropdown-menu-end shadow amd-share-dropdown"
                                            aria-labelledby="shareDropdown">
                                            <li><a class="dropdown-item" href="https://facebook.com" target="_blank"><i
                                                        class="bi bi-facebook"></i> Facebook</a></li>
                                            <li><a class="dropdown-item" href="https://twitter.com" target="_blank"><i
                                                        class="bi bi-twitter-x"></i> Twitter (X)</a></li>
                                            <li><a class="dropdown-item" href="https://www.linkedin.com/shareArticle"
                                                    target="_blank"><i class="bi bi-linkedin"></i> LinkedIn</a></li>
                                            <li><a class="dropdown-item"
                                                    href="https://api.whatsapp.com/send?text=Check%20this%20out!"
                                                    target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp</a></li>
                                        </ul>
                                    </div>

                                    <i class="bi bi-download"></i>
                                </div>
                            </div>
                        </div>


                        <!-- Details Row -->
                        <div class="row g-5">
                            <div class="col-md-7">
                                <h5 class="amd-book-detail-page-section-title">Description</h5>
                                <p class="amd-book-detail-page-section-content">
                                   {!! $data['record']->description ?? '' !!}
                                </p>


                                <div class="d-flex align-items-center gap-3 amd-book-detail-page-review">
                                    <img src="../assets/imgs/GK.png" alt="Roberto Jordan"
                                        class="amd-book-detail-page-review-avatar" />
                                    <div>
                                        <p class="mb-1 amd-book-detail-page-reviewer-name">Roberto Jordan</p>
                                        <p class="mb-0 amd-book-detail-page-review-text">
                                            "What a delightful and magical book it is! It indeed transports readers to
                                            the
                                            wizarding world."
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Use mt-4 mt-md-0 to add space only when columns stack on mobile -->
                            <div class="col-md-5 mt-4 mt-md-0">
                                <div class="mb-4">
                                    <h5 class="amd-book-detail-page-section-title">Editors</h5>
                                    <p class="amd-book-detail-page-section-content">
                                        J.K. Rowling (author), Christopher Reath, Alena Cestabon, Steve Korg
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="amd-book-detail-page-section-title">Language</h5>
                                    <p class="amd-book-detail-page-section-content">Standard English (USA & UK)</p>
                                </div>
                                <div>
                                    <h5 class="amd-book-detail-page-section-title">Paperback</h5>
                                    <p class="amd-book-detail-page-section-content">
                                        paper textured, full colour, 345 pages<br />ISBN: 987 3 32564 455 B
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="amd-book-section">
            <div class="container">
                <div class="amd-book-section-bg-text">Related Books</div>
                <div class="amd-book-section-header">
                    <h2 class="amd-global-title-highlight">Realated</h2>
                    <a href="#" class="amd-book-view-all">
                        <!-- From Uiverse.io by Li-Deheng -->
                        <button class="button">
                            <span>View All</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 66 43">
                                <polygon points="39.58,4.46 44.11,0 66,21.5 44.11,43 39.58,38.54 56.94,21.5"></polygon>
                                <polygon points="19.79,4.46 24.32,0 46.21,21.5 24.32,43 19.79,38.54 37.15,21.5">
                                </polygon>
                                <polygon points="0,4.46 4.53,0 26.42,21.5 4.53,43 0,38.54 17.36,21.5"></polygon>
                            </svg>
                        </button>
                    </a>
                </div>
                <div class="amd-book-section-carousel-wrapper">
                    <button class="amd-book-section-nav amd-book-section-nav-prev" aria-label="Previous">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <div class="amd-book-section-carousel">
                        <!-- Book Item 1 -->
                        <a href="book-detail.html" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/GK.png" alt="Book Cover: City of Ashes">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <!-- UPDATED: Image of open book -->
                                        <img src="../assets/imgs/Environment-science.png" alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>City of Ashes</h3>
                                <p>by: Friedrich Wilhelm</p>
                            </div>
                        </a>
                        <!-- Book Item 2 -->
                        <a href="#" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/Environment-science.png"
                                            alt="Book Cover: Soul Kitchen">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <img src="https://images.pexels.com/photos/1517077/pexels-photo-1517077.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                            alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>Soul Kitchen</h3>
                                <p>by: Jane Doe</p>
                            </div>
                        </a>
                        <!-- Book Item 1 -->
                        <a href="#" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/GK.png" alt="Book Cover: City of Ashes">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <!-- UPDATED: Image of open book -->
                                        <img src="../assets/imgs/Environment-science.png" alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>City of Ashes</h3>
                                <p>by: Friedrich Wilhelm</p>
                            </div>
                        </a>
                        <!-- Book Item 2 -->
                        <a href="#" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/Environment-science.png"
                                            alt="Book Cover: Soul Kitchen">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <img src="https://images.pexels.com/photos/1517077/pexels-photo-1517077.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                            alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>Soul Kitchen</h3>
                                <p>by: Jane Doe</p>
                            </div>
                        </a>
                        <!-- Book Item 1 -->
                        <a href="#" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/GK.png" alt="Book Cover: City of Ashes">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <!-- UPDATED: Image of open book -->
                                        <img src="../assets/imgs/Environment-science.png" alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>City of Ashes</h3>
                                <p>by: Friedrich Wilhelm</p>
                            </div>
                        </a>
                        <!-- Book Item 2 -->
                        <a href="#" class="amd-book-section-item">
                            <div class="amd-book-section-flipper">
                                <div class="amd-book-section-flip-inner">
                                    <div class="amd-book-section-front">
                                        <img src="../assets/imgs/Environment-science.png"
                                            alt="Book Cover: Soul Kitchen">
                                    </div>
                                    <div class="amd-book-section-back">
                                        <img src="https://images.pexels.com/photos/1517077/pexels-photo-1517077.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                            alt="Open book pages">
                                    </div>
                                </div>
                            </div>
                            <div class="amd-book-section-info">
                                <h3>Soul Kitchen</h3>
                                <p>by: Jane Doe</p>
                            </div>
                        </a>
                    </div>
                    <button class="amd-book-section-nav amd-book-section-nav-next" aria-label="Next">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>

@endsection