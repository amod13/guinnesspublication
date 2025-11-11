@extends('publication::site.main.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-center vh-100 bg-light custom-404-bg mt-5">
        <div class="text-center p-4 p-md-5 bg-white rounded-4 shadow-lg custom-card animate__animated animate__fadeIn">
            <h1 class="display-1 fw-bold text-danger custom-error-code">404</h1>
            <h2 class="display-6 text-dark mb-3 custom-title">
                <i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i>
                Oops! Page Not Found
            </h2>
            <p class="lead text-muted mb-4">
                The page you’re looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>

            <a href="{{ url('/') }}" class="btn btn-primary btn-lg custom-home-button shadow-sm">
                <i class="bi bi-house-door-fill me-2"></i>
                Back to Homepage
            </a>

            <div class="mt-4">
                <a href="javascript:history.back()" class="text-decoration-none text-secondary small">
                    <i class="bi bi-arrow-left-circle me-1"></i>
                    Go Back to Previous Page
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Background with soft gradient */
    .custom-404-bg {
        background: linear-gradient(135deg, #f8f9fa 0%, #e8f0fe 100%) !important;
    }

    /* Center card */
    .custom-card {
        max-width: 500px;
        width: 95%;
    }

    /* Big error number with shadow */
    .custom-error-code {
        color: #dc3545;
        text-shadow: 2px 4px 6px rgba(0, 0, 0, 0.1);
        letter-spacing: -2px;
    }

    /* Smooth hover animation for button */
    .custom-home-button {
        transition: all 0.2s ease-in-out;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
    }

    .custom-home-button:hover {
        transform: translateY(-2px);
        background-color: #0d6efd;
    }

    /* Animation (optional: use Animate.css if loaded) */
    .animate__fadeIn {
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Mobile friendly adjustments */
    @media (max-width: 576px) {
        .custom-error-code {
            font-size: 5em !important;
        }
        .custom-title {
            font-size: 1.6em !important;
        }
    }
</style>
@endsection
