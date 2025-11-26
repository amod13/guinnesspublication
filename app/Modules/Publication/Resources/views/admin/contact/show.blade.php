@extends('admin.main.app')
@section('content')

<div class="message-detail-container py-5">
    <div class="container">
        <!-- Back Navigation -->
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <!-- Contact Information Card -->
                <div class="info-card bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <h5 class="fw-bold mb-4 pb-3 border-bottom">
                        <i class="fas fa-user-circle text-primary me-2"></i>Contact Information
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <label class="form-label text-muted small fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Full Name
                                </label>
                                <p class="h5 text-dark mb-0">{{ $message->full_name }}</p>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="contact-item">
                                <label class="form-label text-muted small fw-semibold">
                                    <i class="fas fa-envelope me-2 text-success"></i>Email Address
                                </label>
                                <p class="h5 mb-0">
                                    <a href="mailto:{{ $message->contact_email }}"
                                       class="text-decoration-none text-dark hover-primary">
                                        {{ $message->contact_email }}
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="contact-item">
                                <label class="form-label text-muted small fw-semibold">
                                    <i class="fas fa-heading me-2 text-info"></i>Subject
                                </label>
                                <p class="h5 text-dark mb-0">{{ $message->subject }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Content Card -->
                <div class="info-card bg-white rounded-4 p-4 mb-4 shadow-sm">
                    <h5 class="fw-bold mb-4 pb-3 border-bottom">
                        <i class="fas fa-message text-warning me-2"></i>Message
                    </h5>

                    <div class="message-content bg-light rounded-3 p-4 border-start border-4 border-primary"
                         style="white-space: pre-wrap; line-height: 1.8; color: #333; font-size: 1.05rem;">
                        {{ $message->message }}
                    </div>
                </div>

                <!-- Metadata Card -->
                <div class="info-card bg-white rounded-4 p-4 shadow-sm">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="metadata-item">
                                <i class="fas fa-calendar-alt text-primary me-2" style="font-size: 1.5rem;"></i>
                                <div>
                                    <p class="text-muted small mb-1">Received Date</p>
                                    <p class="fw-bold text-dark">
                                        {{ $message->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="metadata-item">
                                <i class="fas fa-clock text-success me-2" style="font-size: 1.5rem;"></i>
                                <div>
                                    <p class="text-muted small mb-1">Received Time</p>
                                    <p class="fw-bold text-dark">
                                        {{ $message->created_at->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-5 d-flex gap-3 justify-content-center">
                    <a href="mailto:{{ $message->contact_email }}"
                       class="btn btn-primary btn-lg rounded-pill px-5">
                        <i class="fas fa-reply me-2"></i>Reply
                    </a>
                    <button class="btn btn-outline-danger btn-lg rounded-pill px-5"
                            data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                    <a href="{{ route('contact-message.index') }}"
                       class="btn btn-outline-secondary btn-lg rounded-pill px-5">
                        <i class="fas fa-list me-2"></i>View All
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-trash-alt me-2"></i>Delete Message
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-0">
                    <strong>Are you sure you want to delete this message?</strong>
                </p>
                <p class="text-muted small mt-2 mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 gap-2">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form action="{{ route('contact-message.destroy', $message->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-pill">
                        <i class="fas fa-trash me-2"></i>Delete Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
    .message-detail-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .message-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .message-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .message-header::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -5%;
        width: 250px;
        height: 250px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-card {
        background: white;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-card:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1) !important;
        transform: translateY(-5px);
    }

    .contact-item {
        transition: all 0.3s ease;
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .contact-item:hover {
        background-color: #f8f9fa;
    }

    .contact-item label {
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .hover-primary:hover {
        color: #667eea !important;
    }

    .message-content {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .metadata-item {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 0.5rem;
    }

    .metadata-item p {
        margin: 0;
    }

    /* Button Animations */
    .btn {
        transition: all 0.3s ease;
    }

    .btn-lg {
        padding: 0.8rem 1.5rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .btn-outline-danger:hover {
        transform: translateY(-2px);
    }

    .btn-outline-secondary:hover {
        transform: translateY(-2px);
    }

    /* Modal Styling */
    .modal-content {
        border: none !important;
    }

    .modal-header {
        padding: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .message-header {
            padding: 2rem !important;
        }

        .message-header h1 {
            font-size: 1.75rem;
        }

        .avatar-circle {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }

        .btn-lg {
            width: 100%;
        }

        .d-flex.gap-3 {
            flex-direction: column;
        }
    }
</style>

@endsection
