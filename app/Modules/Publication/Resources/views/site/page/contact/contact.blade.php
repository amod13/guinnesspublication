@extends('publication::site.main.app')
@section('content')
    <section class="amd-breadcrumb-section">
        <nav class="breadcrumb-container-amd" aria-label="breadcrumb">
            <ol class="breadcrumb-list-amd">
                <li class="breadcrumb-item-amd">
                    <a href="{{ url('/') }}" class="breadcrumb-link-amd">Home</a>
                </li>
                <li class="breadcrumb-item-amd">
                    <a href="#" class="breadcrumb-link-amd">Contact Us</a>
                </li>
            </ol>
        </nav>
    </section>

    <div class="sucess-message">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <section class="amd-book-contact-page-wrapper ">
        <div class="amd-book-contact-page container">
            <!-- Left Page -->
            <div class="amd-book-contact-page-page amd-book-contact-page-left">
                <div class="amd-book-contact-page-header">

                    <div class="amd-book-section-header amd-book-contact-head-wrap">
                        <h2 class="amd-global-title-highlight">Get In Touch</h2>
                    </div>
                    <p>Drop us a line—whether it’s ideas, feedback, or just a hello, we can’t wait to hear from you!</p>
                </div>
                <div class="amd-book-contact-page-details">
                    <ul>
                        @if (!empty($data['setting']->email))
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>{{ $data['setting']->email }}</span>
                            </li>
                        @endif
                        @if (!empty($data['setting']->address))
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $data['setting']->address }}</span>
                            </li>
                        @endif
                        @if (!empty($data['setting']->address))
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>{{ $data['setting']->phone }}</span>
                            </li>
                        @endif
                    </ul>


                    <div class="amd-social-links">
                        @if (!empty($data['setting']->facebook))
                            <li><a href="{{ $data['setting']->facebook }}" target="_blank">
                                    <i class="bi bi-facebook"></i>
                                </a></li>
                        @endif

                        @if (!empty($data['setting']->instagram))
                            <li><a href="{{ $data['setting']->instagram }}" target="_blank">
                                    <i class="bi bi-instagram"></i>
                                </a></li>
                        @endif

                        @if (!empty($data['setting']->twitter))
                            <li><a href="{{ $data['setting']->twitter }}" target="_blank">
                                    <i class="bi bi-twitter-x"></i>
                                </a></li>
                        @endif

                        @if (!empty($data['setting']->youtube))
                            <li><a href="{{ $data['setting']->youtube }}" target="_blank">
                                    <i class="bi bi-youtube"></i>
                                </a></li>
                        @endif

                        @if (!empty($data['setting']->website))
                            <li><a href="{{ $data['setting']->website }}" target="_blank">
                                    <i class="bi bi-globe"></i>
                                </a></li>
                        @endif
                    </div>
                </div>

            </div>
            <!-- Right Page -->
            <div class="amd-book-contact-page-page amd-book-contact-page-right">
                <form action="{{ route('store.contact.us', ['locale' => app()->getLocale()]) }}" method="POST">
                    @csrf
                    <div class="amd-contact-page-form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="full_name" name="full_name">
                        <span class="text-danger">
                            @error('full_name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-contact-page-form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="contact_email">
                        <span class="text-danger">
                            @error('contact_email')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-contact-page-form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject">
                        <span class="text-danger">
                            @error('subject')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="amd-contact-page-form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message"></textarea>
                        <span class="text-danger">
                            @error('message')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <button type="submit" class="amd-contact-page-submit-btn">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    @if (!empty($data['setting']->google_map))
        <section class="amd-contact-page-map container">
            <div class="amd-book-section-header ">
                <h2 class="amd-global-title-highlight">Our Location</h2>
            </div>
            <div class="amd-contact-page-map-container">
                {!! $data['setting']->google_map ?? '' !!}
            </div>
        </section>
    @endif
@endsection
