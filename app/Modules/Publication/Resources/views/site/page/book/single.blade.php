@extends('publication::site.main.app')
@section('content')

    <style>
        :root {
            --c-bg: #fff;
            --c-bg-secondary: #f7f7f7;
            --c-bg-surface: #e9ecef;
            --c-text-primary: #1a1a1a;
            --c-text-secondary: #595959;
            --c-border: #e6e6e6;
            --c-accent: #1e7b55;
            --c-highlight: #ffeb3b;
            --c-highlight-text: #000;
        }

        [data-theme="dark"] {
            --c-bg: #121212;
            --c-bg-secondary: #1e1e1e;
            --c-bg-surface: #2a2a2a;
            --c-text-primary: #e0e0e0;
            --c-text-secondary: #a0a0a0;
            --c-border: #3a3a3a;
            --c-accent: #2e9a71;
            --c-highlight: #fbc02d;
        }

        body {
            background-color: var(--c-bg);
            color: var(--c-text-primary);
            font-family: 'Inter', sans-serif;
            margin: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        button,
        input {
            font-family: 'Inter', sans-serif;
        }

        .amd-doc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 24px;
            border-bottom: 1px solid var(--c-border);
            background-color: var(--c-bg);
        }

        .amd-doc-header-left,
        .amd-doc-header-center,
        .amd-doc-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .amd-doc-header-center {
            flex-grow: 1;
            padding: 0 40px;
        }

        .amd-doc-icon-btn {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--c-text-secondary);
            padding: 8px;
        }

        .amd-doc-logo {
            color: var(--c-text-primary);
            font-weight: 700;
            font-size: 20px;
        }

        .amd-doc-search-bar input {
            width: 100%;
            padding: 10px 40px 10px 16px;
            border-radius: 20px;
            font-size: 16px;
            background-color: var(--c-bg-secondary);
            border: 1px solid var(--c-border);
            color: var(--c-text-primary);
        }

        .amd-doc-search-bar i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-secondary);
        }

        .amd-doc-icon-btn-text {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
            color: var(--c-text-primary);
        }

        .amd-doc-signin-link {
            text-decoration: none;
            color: var(--c-text-primary);
            font-weight: 500;
        }

        .amd-doc-cta-btn-green {
            background-color: var(--c-accent);
            color: #fff;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .amd-doc-main-layout {
            display: grid;
            grid-template-columns: minmax(0, 2fr) 320px;
            gap: 40px;
            max-width: 1400px;
            margin: 24px auto;
            padding: 0 24px;
        }

        .amd-doc-content-left {
            min-width: 0;
        }

        .amd-doc-meta {
            display: flex;
            gap: 16px;
            font-size: 14px;
            color: var(--c-text-secondary);
            margin-bottom: 12px;
        }

        .amd-doc-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 16px 0;
        }

        .amd-doc-description {
            font-size: 16px;
            line-height: 1.6;
            color: var(--c-text-secondary);
            transition: max-height 0.4s ease-in-out;
            max-height: 4.8em;
            overflow: hidden;
        }

        .amd-doc-description.is-expanded {
            max-height: 1000px;
        }

        .amd-doc-description-more {
            display: none;
        }

        .amd-doc-description.is-expanded .amd-doc-description-more {
            display: inline;
        }

        .amd-doc-description strong {
            color: var(--c-text-primary);
            cursor: pointer;
        }

        .amd-doc-uploader {
            font-size: 14px;
            color: var(--c-text-secondary);
            margin: 24px 0;
            display: flex;
            flex-direction: row;
            gap: 8px;
        }

        .amd-doc-uploader a {
            color: #0066cc;
            text-decoration: underline;
        }

        .amd-doc-ai-tag {
            color: #5a3285;
        }

        .amd-doc-actions-primary {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: end;
        }

        .amd-doc-actions-primary button {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--c-text-secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 8px;
            width: 70px;
            border-radius: 4px;
        }

        .amd-doc-actions-primary button:hover {
            background-color: var(--c-bg-secondary);
        }

        .amd-doc-actions-primary button.is-active,
        button.amd-doc-icon-btn.is-active {
            color: var(--c-accent);
        }

        .amd-doc-separator {
            border: none;
            border-top: 1px solid var(--c-border);
            margin: 24px 0;
        }

        #amd-doc-sticky-trigger {
            height: 1px;
        }

        .amd-doc-actions-secondary {
            display: flex;
            align-items: center;
            padding-bottom: 24px;
            position: relative;
            transition: all 0.3s ease;
            /* overflow: hidden; */
            height: 42px;
        }

        .amd-doc-actions-secondary.is-sticky {
            position: sticky;
            top: 0;
            background-color: rgba(var(--c-bg-rgb, 255, 255, 255), 0.95);
            backdrop-filter: blur(8px);
            padding: 43px 0px;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 12px;

            height: auto;
        }

        [data-theme="dark"] .amd-doc-actions-secondary.is-sticky {
            background-color: rgba(var(--c-bg-rgb, 18, 18, 18), 0.95);
        }

        .amd-doc-actions-default-view {
            display: flex;
            justify-content: space-between;
            width: 100%;
            transition: opacity 0.3s, transform 0.3s;
            position: absolute;
        }

        .amd-doc-actions-find-view {
            display: flex;
            align-items: center;
            width: 100%;
            position: absolute;
            opacity: 0;
            transform: translateY(20px);
            pointer-events: none;
            transition: opacity 0.3s, transform 0.3s;
        }

        .amd-doc-actions-secondary.is-searching .amd-doc-actions-default-view {
            opacity: 0;
            transform: translateY(-20px);
            pointer-events: none;
        }

        .amd-doc-actions-secondary.is-searching .amd-doc-actions-find-view {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .amd-doc-actions-secondary-left,
        .amd-doc-actions-secondary-right {
            display: flex;
            align-items: center;
            padding: 0 10px 0 10px;
            gap: 16px;
        }

        .amd-doc-download-dropdown-wrapper,
        .amd-doc-more-actions-wrapper {
            position: relative;
        }

        .amd-doc-download-btn-green {
            background-color: var(--c-accent);
            color: #fff;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .amd-doc-download-btn-green i.fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .amd-doc-download-btn-green.is-open i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .amd-doc-download-dropdown,
        .amd-doc-more-actions-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background-color: var(--c-bg);
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            width: 200px;
            z-index: 20;
            list-style: none;
            padding: 8px 0;
            margin: 0;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: opacity 0.3s, transform 0.3s, visibility 0.3s;
        }

        .amd-doc-more-actions-dropdown {
            right: 0;
            left: auto;
        }

        .amd-doc-download-dropdown.is-active,
        .amd-doc-more-actions-dropdown.is-active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .amd-doc-download-dropdown a,
        .amd-doc-more-actions-dropdown a {
            display: block;
            padding: 10px 16px;
            text-decoration: none;
            color: var(--c-text-primary);
            white-space: nowrap;
        }

        .amd-doc-download-dropdown a:hover,
        .amd-doc-more-actions-dropdown a:hover {
            background-color: var(--c-bg-secondary);
        }

        .amd-doc-download-dropdown a i {
            margin-right: 8px;
        }

        .amd-doc-page-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .amd-doc-page-nav input {
            width: 40px;
            text-align: center;
            border: 1px solid var(--c-border);
            border-radius: 4px;
            padding: 6px;
            background: none;
            color: var(--c-text-primary);
        }

        .amd-doc-find-bar {
            border: 1px solid var(--c-border);
            border-radius: 8px;
            padding: 8px 12px;
            cursor: pointer;
            background: none;
            color: var(--c-text-primary);
        }

        .amd-doc-actions-find-view>i {
            color: var(--c-text-secondary);
        }

        .amd-doc-actions-find-view input {
            flex-grow: 1;
            border: none;
            background: none;
            font-size: 16px;
            padding: 0 10px;
            color: var(--c-text-primary);
            outline: none;
        }

        .amd-doc-find-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--c-text-secondary);
        }

        .amd-doc-find-controls button {
            background: none;
            border: 1px solid var(--c-border);
            color: var(--c-text-primary);
            cursor: pointer;
            border-radius: 4px;
            padding: 4px 8px;
        }

        .amd-doc-find-controls button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .amd-doc-viewer {
            width: 100%;
            border: 1px solid var(--c-border);
            background: var(--c-bg-surface);
            overflow-y: scroll;
            height: 110vh;
            scroll-behavior: smooth;
            padding: 20px 0;
        }

        .amd-doc-viewer-page {
            height: 1123px;
            width: 794px;
            margin: 20px auto;
            background: var(--c-bg);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
            border: 1px solid var(--c-border);
            position: relative;
        }

        .amd-doc-page-content {
            padding: 60px;
            text-align: left;
            color: var(--c-text-primary);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--c-accent);
            padding-bottom: 10px;
            margin-bottom: 40px;
            color: var(--c-accent);
            font-weight: 600;
        }

        .page-header img {
            height: 40px;
            opacity: 0.7;
        }

        .amd-doc-page-content h2 {
            font-size: 24px;
        }

        .amd-doc-page-content h3 {
            font-size: 18px;
            border-bottom: 1px solid var(--c-border);
        }

        .amd-doc-page-content p {
            font-size: 14px;
            line-height: 1.8;
        }

        .demo-image-container {
            margin-top: 30px;
            text-align: center;
        }

        .demo-image-container img {
            max-width: 100%;
            border: 1px solid var(--c-border);
        }

        caption {
            display: block;
            margin-top: 10px;
            font-size: 12px;
            color: var(--c-text-secondary);
            font-style: italic;
        }

        .demo-chart-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            height: 250px;
            border-left: 2px solid var(--c-border);
            border-bottom: 2px solid var(--c-border);
            padding: 20px;
        }

        .demo-chart-bar {
            width: 18%;
            background-color: #0d6efd;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .demo-chart-bar .label {
            position: absolute;
            bottom: -30px;
            color: var(--c-text-primary);
            font-weight: 500;
        }

        .page-footer {
            position: absolute;
            bottom: 20px;
            right: 20px;
            font-size: 12px;
            color: var(--c-text-secondary);
        }

        .amd-doc-sidebar-right {
            position: sticky;
            top: 24px;
            align-self: start;
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .amd-doc-mobile-sheet-toggle {
            display: none;
        }

        .amd-doc-related-list {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .amd-doc-related-item {
            display: flex;
            gap: 16px;
            text-decoration: none;
            color: inherit;
        }

        .amd-doc-related-img-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .amd-doc-related-img-wrapper img {
            width: 80px;
            height: 110px;
            object-fit: cover;
            border: 1px solid var(--c-border);
        }

        .amd-doc-file-tag {
            position: absolute;
            top: 4px;
            left: 4px;
            background-color: rgba(0, 0, 0, 0.6);
            color: #fff;
            font-size: 10px;
            padding: 2px 4px;
            border-radius: 2px;
        }

        .amd-doc-related-info {
            display: flex;
            flex-direction: column;
        }

        .amd-doc-related-title {
            font-size: 14px;
        }

        .amd-doc-bottom-sheet {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
            pointer-events: none;
        }

        .amd-doc-bottom-sheet-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .amd-doc-bottom-sheet-content {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            max-height: 60%;
            background: var(--c-bg);
            border-radius: 16px 16px 0 0;
            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(100%);
            transition: transform 0.4s ease-out;
            display: flex;
            flex-direction: column;
        }

        .amd-doc-bottom-sheet.is-open {
            pointer-events: auto;
        }

        .amd-doc-bottom-sheet.is-open .amd-doc-bottom-sheet-overlay {
            opacity: 1;
        }

        .amd-doc-bottom-sheet.is-open .amd-doc-bottom-sheet-content {
            transform: translateY(0);
        }

        .amd-doc-bottom-sheet-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid var(--c-border);
            flex-shrink: 0;
        }

        .amd-doc-bottom-sheet-header h3 {
            margin: 0;
            font-size: 16px;
        }

        .amd-doc-related-pages {
            font-size: 0.7rem;
            color: rgb(152, 152, 152);
            font-weight: 600;
        }

        .amd-doc-bottom-sheet-close {
            background: none;
            border: none;
            font-size: 20px;
            color: var(--c-text-secondary);
            cursor: pointer;
        }

        .amd-doc-sheet-grid-container {
            padding: 16px;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 16px;
        }

        .amd-doc-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .amd-doc-modal.is-active {
            opacity: 1;
            visibility: visible;
        }

        .amd-doc-modal-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        .amd-doc-modal-content {
            position: relative;
            background: var(--c-bg);
            border-radius: 8px;
            padding: 24px;
            width: 90%;
            max-width: 500px;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .amd-doc-modal.is-active .amd-doc-modal-content {
            transform: scale(1);
        }

        .amd-doc-modal-close {
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 24px;
            background: none;
            border: none;
            cursor: pointer;
            color: #aaa;
        }

        .amd-doc-toast {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--c-text-primary);
            color: var(--c-bg);
            padding: 12px 24px;
            border-radius: 30px;
            z-index: 2000;
            font-size: 14px;
            transition: bottom 0.5s ease;
        }

        .amd-doc-toast.is-active {
            bottom: 30px;
        }

        mark.amd-doc-highlight {
            background-color: var(--c-highlight);
            color: var(--c-highlight-text);
            border-radius: 3px;
        }

        mark.amd-doc-highlight.current {
            box-shadow: 0 0 0 2px var(--c-accent);
        }

        @media (max-width: 992px) {
            .amd-doc-main-layout {
                grid-template-columns: 1fr;
            }

            .amd-doc-sidebar-right {
                position: static;
                margin-top: 40px;
                animation: none;
                opacity: 1;
            }

            .amd-doc-sidebar-desktop-content {
                display: none;
            }

            .amd-doc-mobile-sheet-toggle {
                display: flex;
            }

            .amd-doc-viewer {
                height: 80vh;
            }

            .amd-doc-viewer-page {
                width: 95%;
                max-width: 794px;
                height: auto;
                min-height: 500px;
            }

            .amd-doc-page-content {
                padding: 30px;
            }
        }

        @media (max-width: 768px) {

            .amd-doc-header-center,
            #amd-doc-lang-btn,
            #amd-doc-upload-btn,
            .amd-doc-signin-link {
                display: none;
            }

            /* 
                .amd-doc-actions-secondary-right {
                    display: none;
                } */
            .amd-find-text {
                display: none;
            }

            .amd-doc-title {
                font-size: 24px;
            }
        }
    </style>


    <style>
        <style>

        /* Custom CSS for the section containing the background image */
        .bg-image-section {
            min-height: 220px;
            /* Adjust height as needed */

            /* Background Image Properties */
            background-size: cover;
            /* Ensures the image covers the entire area */
            background-position: center;
            /* Centers the image */
            background-repeat: no-repeat;
            /* Prevents image repetition */

            /* Overlay for Text Readability: */
            /* This creates a dark layer over the image to make white text pop more. */
            background-blend-mode: multiply;
            /* Blends the background-color with the image */
            background-color: rgba(0, 0, 0, 0.6);
            /* Dark grey overlay, adjust '0.6' for intensity */

            /* Optional: Flexbox for vertical centering content if needed */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Enhancements for breadcrumb text on the background image */
        .bg-image-section .breadcrumb a,
        .bg-image-section .breadcrumb .active {
            color: #fff !important;
            /* Ensure white color for links and active item */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
            /* Subtle shadow for better contrast */
        }
    </style>
    </style>


    <div class="bg-image-section p-5 d-flex flex-column justify-content-center mt-5"
        style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1H4PZrSs0p0fQXR6f-IUvezMdjcgxrFjCkg&s');">

        <h1 class="display-4 text-white font-weight-bold mt-2"> <a href="{{ url('/') }}">Home</a> / {{ $data['book']->title }}</h1>

    </div>

    <!-- Main Content Layout -->
    <div class="amd-doc-main-layout">
        <!-- Left Column -->
        <main class="amd-doc-content-left">
            <div class="amd-doc-meta"><span><i class="far fa-thumbs-up"></i> 0 ratings</span><span><i
                        class="fas fa-eye"></i> 36K views</span>
            </div>
            <h1 class="amd-doc-title">{{ $data['book']->title }}</h1>
            <div class="amd-doc-description" id="amd-doc-description-wrapper">
                <p>{{ $data['book']->description }}</p>
            </div>
            <div class="amd-doc-uploader">Uploaded by :
                <a href="#">{{ $data['setting']->site_name ?? '' }}</a>
            </div>
            <hr class="amd-doc-separator">
            <div id="amd-doc-sticky-trigger"></div>

            <div class="amd-doc-viewer" id="amd-doc-viewer">
                            <iframe id="pdf-viewer" src="{{ route('books.pdf', $data['book']->id ?? '') }}" width="100%" height="800px"
                frameborder="0">
            </iframe>
            </div>
        </main>

        <aside class="amd-doc-sidebar-right">
            <div class="amd-doc-sidebar-desktop-content">
                <h3>You might also like</h3>
                <div class="amd-doc-related-list">
                    <a href="#" class="amd-doc-related-item">
                        <div class="amd-doc-related-img-wrapper"><img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT5Y21sP1e0e2fwn-sIrrX7Ch8HXiquv0IN2A&s"
                                alt="Document Cover"><span class="amd-doc-file-tag">PDF</span></div>
                        <div class="amd-doc-related-info"><span class="amd-doc-related-rating">No ratings yet</span>
                            <p class="amd-doc-related-title">Sinful Like Us by Ritchie Krista Ritchie</p><span
                                class="amd-doc-related-pages">403 pages</span>
                        </div>
                    </a>
                    <a href="#" class="amd-doc-related-item">
                        <div class="amd-doc-related-img-wrapper"><img
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVtNBAtzz2FvHs-KA6FAvnZID2rQ9DU2JlMA&s"
                                alt="Document Cover"><span class="amd-doc-file-tag">PDF</span></div>
                        <div class="amd-doc-related-info"><span class="amd-doc-related-rating"><i
                                    class="fas fa-thumbs-up"></i> 100% (1)</span>
                            <p class="amd-doc-related-title">Ick Factor - Morgan Elizabeth</p><span
                                class="amd-doc-related-pages">339 pages</span>
                        </div>
                    </a>
                </div>
            </div>
            <button class="amd-doc-mobile-sheet-toggle" id="amd-doc-mobile-sheet-toggle"><span>You might also
                    like</span><i class="fas fa-chevron-up"></i></button>
        </aside>
    </div>

    <div class="amd-doc-modal" id="amd-doc-modal">
        <div class="amd-doc-modal-overlay"></div>
        <div class="amd-doc-modal-content"><button class="amd-doc-modal-close">&times;</button>
            <h3 class="amd-doc-modal-title"></h3>
            <div class="amd-doc-modal-body"></div>
        </div>
    </div>
    <div class="amd-doc-toast" id="amd-doc-toast"></div>
    <div class="amd-doc-bottom-sheet" id="amd-doc-bottom-sheet">
        <div class="amd-doc-bottom-sheet-overlay"></div>
        <div class="amd-doc-bottom-sheet-content">
            <div class="amd-doc-bottom-sheet-header">
                <h3>You might also like</h3><button class="amd-doc-bottom-sheet-close" aria-label="Close"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="amd-doc-sheet-grid-container"></div>
        </div>
    </div>

    <script>
        (function () {
            'use strict';

            document.addEventListener('DOMContentLoaded', function () {

                // --- Helper Elements ---
                const modal = document.getElementById('amd-doc-modal');
                const toast = document.getElementById('amd-doc-toast');
                let toastTimeout;

                function openModal(title, content) {
                    modal.querySelector('.amd-doc-modal-title').textContent = title;
                    modal.querySelector('.amd-doc-modal-body').innerHTML = content;
                    modal.classList.add('is-active');
                }

                function closeModal() { modal.classList.remove('is-active'); }

                function showToast(message) {
                    clearTimeout(toastTimeout);
                    toast.textContent = message;
                    toast.classList.add('is-active');
                    toastTimeout = setTimeout(() => toast.classList.remove('is-active'), 3000);
                }

                // --- Theme Switcher ---
                function initThemeSwitcher() {
                    const themeToggle = document.getElementById('amd-doc-theme-toggle');
                    if (!themeToggle) return;
                    const themeIcon = themeToggle.querySelector('i');

                    function setRgbColor(theme) {
                        const hex = theme === 'dark' ? '#121212' : '#ffffff';
                        const rgb = `${parseInt(hex.slice(1, 3), 16)}, ${parseInt(hex.slice(3, 5), 16)}, ${parseInt(hex.slice(5, 7), 16)}`;
                        document.documentElement.style.setProperty('--c-bg-rgb', rgb);
                    }

                    function setTheme(theme) {
                        document.body.dataset.theme = theme;
                        localStorage.setItem('theme', theme);
                        themeIcon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                        setRgbColor(theme);
                    }

                    const currentTheme = localStorage.getItem('theme') || 'light';
                    setTheme(currentTheme);

                    themeToggle.addEventListener('click', () => {
                        const newTheme = document.body.dataset.theme === 'light' ? 'dark' : 'light';
                        setTheme(newTheme);
                    });
                }

                // --- Search & Highlight ---
                function initSearchAndHighlight() {
                    const secondaryActionsBar = document.getElementById('amd-doc-actions-secondary');
                    const findBtn = document.getElementById('amd-doc-find-btn');
                    const findInput = document.getElementById('amd-doc-find-input');
                    const findCloseBtn = document.getElementById('amd-doc-find-close');
                    const viewer = document.getElementById('amd-doc-viewer');
                    const counterEl = document.getElementById('amd-doc-find-counter');
                    const nextBtn = document.getElementById('amd-doc-find-next');
                    const prevBtn = document.getElementById('amd-doc-find-prev');
                    if (!findBtn || !secondaryActionsBar || !viewer) return;
                    const originalViewerHTML = viewer.innerHTML;
                    let matches = [];
                    let currentIndex = -1;

                    findBtn.addEventListener('click', () => {
                        secondaryActionsBar.classList.add('is-searching');
                        findInput.focus();
                    });
                    findCloseBtn.addEventListener('click', () => {
                        secondaryActionsBar.classList.remove('is-searching');
                        viewer.innerHTML = originalViewerHTML;
                        findInput.value = '';
                        matches = []; currentIndex = -1;
                        updateNavButtons();
                    });

                    function updateSearch() {
                        const searchTerm = findInput.value;
                        viewer.innerHTML = originalViewerHTML;
                        matches = []; currentIndex = -1;
                        if (searchTerm.trim().length < 2) { updateNavButtons(); return; }
                        const escapedTerm = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // fixed regex
                        const regex = new RegExp(escapedTerm, 'gi');
                        viewer.innerHTML = originalViewerHTML.replace(regex, match => `<mark class="amd-doc-highlight">${match}</mark>`);
                        matches = viewer.querySelectorAll('.amd-doc-highlight');
                        if (matches.length > 0) { currentIndex = 0; jumpToMatch(currentIndex); }
                        updateNavButtons();
                    }

                    function jumpToMatch(index) {
                        if (index < 0 || index >= matches.length) return;
                        matches.forEach(m => m.classList.remove('current'));
                        const currentMatch = matches[index];
                        currentMatch.classList.add('current');
                        currentMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        updateNavButtons();
                    }

                    function updateNavButtons() {
                        counterEl.textContent = matches.length > 0 ? `${currentIndex + 1} / ${matches.length}` : '0 / 0';
                        prevBtn.disabled = currentIndex <= 0;
                        nextBtn.disabled = currentIndex >= matches.length - 1;
                    }

                    findInput.addEventListener('input', updateSearch);
                    nextBtn.addEventListener('click', () => { if (currentIndex < matches.length - 1) jumpToMatch(++currentIndex); });
                    prevBtn.addEventListener('click', () => { if (currentIndex > 0) jumpToMatch(--currentIndex); });
                }

                // --- Mobile Bottom Sheet ---
                function initMobileBottomSheet() {
                    const toggle = document.getElementById('amd-doc-mobile-sheet-toggle');
                    const sheet = document.getElementById('amd-doc-bottom-sheet');
                    if (!toggle || !sheet) return;
                    const closeBtn = sheet.querySelector('.amd-doc-bottom-sheet-close');
                    const overlay = sheet.querySelector('.amd-doc-bottom-sheet-overlay');
                    const contentContainer = sheet.querySelector('.amd-doc-sheet-grid-container');
                    const desktopContent = document.querySelector('.amd-doc-sidebar-desktop-content .amd-doc-related-list');
                    if (!contentContainer || !desktopContent) return;
                    contentContainer.innerHTML = desktopContent.innerHTML;

                    function openSheet() { sheet.classList.add('is-open'); document.body.style.overflow = 'hidden'; }
                    function closeSheet() { sheet.classList.remove('is-open'); document.body.style.overflow = ''; }

                    toggle.addEventListener('click', openSheet);
                    closeBtn.addEventListener('click', closeSheet);
                    overlay.addEventListener('click', closeSheet);
                }

                // --- Header Actions ---
                function initHeaderActions() {
                    const show = msg => () => showToast(msg);
                    document.getElementById('amd-doc-menu-btn')?.addEventListener('click', show('Menu clicked!'));
                    document.getElementById('amd-doc-lang-btn')?.addEventListener('click', show('Language selection opened!'));
                    document.getElementById('amd-doc-upload-btn')?.addEventListener('click', show('Upload page opened!'));
                    document.getElementById('amd-doc-signin-btn')?.addEventListener('click', show('Sign in page opened!'));
                    document.getElementById('amd-doc-cta-btn')?.addEventListener('click', show('CTA clicked!'));
                    document.getElementById('amd-doc-search-input-header')?.addEventListener('click', show('Global search not implemented in this demo.'));
                }

                // --- Description Toggle ---
                function initDescriptionToggle() {
                    const toggle = document.getElementById('amd-doc-description-toggle');
                    const wrapper = document.getElementById('amd-doc-description-wrapper');
                    if (!toggle || !wrapper) return;
                    toggle.addEventListener('click', () => {
                        const isExpanded = wrapper.classList.toggle('is-expanded');
                        toggle.textContent = isExpanded ? 'Show less' : 'Full description';
                    });
                }

                // --- Dropdown Menus ---
                function initDropdowns() {
                    function setupDropdown(toggleId, menuId) {
                        const toggle = document.getElementById(toggleId);
                        const menu = document.getElementById(menuId);
                        if (!toggle || !menu) return;
                        toggle.addEventListener('click', e => {
                            e.stopPropagation();
                            const isActive = menu.classList.toggle('is-active');
                            toggle.classList.toggle('is-open', isActive);
                        });
                    }
                    setupDropdown('amd-doc-download-toggle', 'amd-doc-download-menu');
                    setupDropdown('amd-action-more-toggle', 'amd-action-more-menu');

                    document.addEventListener('click', () => {
                        document.querySelectorAll('.is-active').forEach(el => el.classList.remove('is-active'));
                        document.querySelectorAll('.is-open').forEach(el => el.classList.remove('is-open'));
                    });
                }

                // --- Primary Actions ---
                function initPrimaryActions() {
                    const shareAction = async () => {
                        const shareData = {
                            title: document.title,
                            text: document.querySelector('.amd-doc-title')?.textContent || 'Check out this document',
                            url: window.location.href
                        };
                        try {
                            if (navigator.share) await navigator.share(shareData);
                            else { await navigator.clipboard.writeText(window.location.href); showToast('Link copied to clipboard!'); }
                        } catch (err) { console.error(err); showToast('Could not share document.'); }
                    };

                    [document.getElementById('amd-action-share'), document.getElementById('amd-action-share-secondary')].forEach(btn => btn?.addEventListener('click', shareAction));
                    document.getElementById('amd-action-download-primary')?.addEventListener('click', () => document.getElementById('amd-doc-download-toggle').click());
                    const saveBtns = [document.getElementById('amd-action-save'), document.getElementById('amd-action-save-secondary')];
                    saveBtns.forEach(btn => btn?.addEventListener('click', function () {
                        const isActive = this.classList.toggle('is-active');
                        saveBtns.forEach(b => b?.classList.toggle('is-active', isActive));
                        showToast(isActive ? 'Saved to your library.' : 'Removed from your library.');
                    }));

                    document.querySelectorAll('.amd-action-rating').forEach(btn => btn.addEventListener('click', function () {
                        showToast('Thank you for your feedback!');
                        this.classList.toggle('is-active');
                    }));

                    [document.getElementById('amd-action-print'), document.getElementById('amd-action-print-secondary')].forEach(btn => btn?.addEventListener('click', () => window.print()));
                    document.getElementById('amd-action-embed')?.addEventListener('click', () => openModal('Embed', '<p>Copy this code to embed in your site:</p><textarea readonly>&lt;iframe src="' + window.location.href + '"&gt;&lt;/iframe&gt;</textarea>'));
                    document.getElementById('amd-action-ask-ai')?.addEventListener('click', () => openModal('Ask AI', '<p>AI feature coming soon!</p>'));
                    [document.getElementById('amd-action-report'), document.getElementById('amd-action-report-secondary')].forEach(btn => btn?.addEventListener('click', () => openModal('Report this document', '<p>Please tell us what is wrong with this document.</p><textarea></textarea><br><button>Submit</button>')));
                }

                // --- Sticky Actions Bar ---
                function initStickyActionsBar() {
                    const trigger = document.getElementById('amd-doc-sticky-trigger');
                    const target = document.getElementById('amd-doc-actions-secondary');
                    if (!trigger || !target) return;
                    const observer = new IntersectionObserver(([entry]) => {
                        target.classList.toggle('is-sticky', !entry.isIntersecting);
                    }, { rootMargin: '0px 0px 0px 0px' });
                    observer.observe(trigger);
                }

                // --- Initialize all ---
                initThemeSwitcher();
                initSearchAndHighlight();
                initMobileBottomSheet();
                initHeaderActions();
                initDescriptionToggle();
                initDropdowns();
                initPrimaryActions();
                initStickyActionsBar();
            });
        })();
    </script>


@endsection