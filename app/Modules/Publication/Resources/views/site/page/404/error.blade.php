                 mj@extends('publication::site.main.app')

@section('content')
      <section class="amd-error-section container">
            <div class="amd-error-container ">
                <!-- Background decorative text -->
                <span class="amd-error-bg-text bg-4-left">4</span>
                <span class="amd-error-bg-text bg-0">0</span>
                <span class="amd-error-bg-text bg-4-right">4</span>
                <!-- Left side content -->
                <div class="amd-error-content">
                    <h1>Oops!</h1>
                    <p>Looks like the page you are looking for does not exist. We're very sorry for the inconvenience.
                    </p>
                    <a href="{{ url('/') }}" class="amd-error-button">Go home</a>
                </div>

                <!-- Right side illustrations -->
                <div class="amd-error-illustration">
                    <!-- Each food item is a div containing an <img> tag -->

                    <!-- Sad crying-book -->
                    <div class="book-items crying-book">
                        <!-- REPLACE with your image URL -->
                        <img src="{{ asset('site/assets/imgs/—Pngtree—big yellow book illustration_4627246.png') }}"
                            alt="Sad potato crying-book character">
                    </div>

                    <!-- Angry crying-book2 -->
                    <div class="book-items crying-book2">
                        <!-- REPLACE with your image URL -->
                        <img src="{{ asset('site/assets/imgs/—Pngtree—crying little book illustration_4751833.png') }}"
                            alt="Angry crying-book2 character">
                    </div>

                    <!-- crying-book3 -->
                    <div class="book-items crying-book3">
                        <!-- REPLACE with your image URL -->
                        <img src="{{ asset('site/assets/imgs/dfe9679787a5872f486187033530d5c4.png') }}" alt="Hot dog character">
                    </div>

                    <!-- crying-book4 -->
                    <div class="book-items crying-book4">
                        <!-- REPLACE with your image URL -->
                        <img src="{{ asset('site/assets/imgs/—Pngtree—big yellow book illustration_4627246.png') }}"
                            alt="Spilled french crying-book4">
                    </div>
                </div>
            </div>
        </section>
@endsection


