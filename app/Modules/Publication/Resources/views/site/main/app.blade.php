<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if (isset($data['setting']) && $data['setting']->site_name)
            {{ $data['setting']->site_name }}{{ !empty($data['header_title']) ? ' - ' . $data['header_title'] : '' }}
        @else
            Guiness Publication{{ !empty($data['header_title']) ? ' - ' . $data['header_title'] : '' }}
        @endif
    </title>
   <meta name="description" content="{{ $data['setting']->site_name ?? '' }}">
    <meta name="keywords" content="{{ $data['setting']->site_name ?? '' }}">

    <!-- Yield page-specific meta -->
    @yield('meta')

        {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('uploads/images/site/' . $data['setting']->favicon) }}"
        type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap.min.css') }}">

    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/slick-theme.css') }}">

    <!-- Swiper.js CSS -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/swiper-bundle.min.css') }}">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-KyZXEAg3QhqLMpG8r+Knujsl5+5hb7ieQZ6+o+3A9nUZFfMQuu7Oc0XUwXJjC7rTI1+oc0Y4Nxxu6i0c2h3iVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
    <!-- Your Custom CSS (Always Last) -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/3dflipbook.css') }}">

    {{-- custom editor --}}
    <link rel="stylesheet" href="{{ asset('site/assets/css/amd-editor.css') }}">

    @stack('styles')

      <style>
        :root {
            @foreach (DB::table('theme_settings')->get() as $setting)
                --{{ str_replace('_', '-', $setting->key_name) }}: {!! $setting->value !!};
            @endforeach
        };
    </style>
</head>

<body>
    @include('publication::site.main.header')

    @yield('content')

    @include('publication::site.main.footer')
</body>

</html>
