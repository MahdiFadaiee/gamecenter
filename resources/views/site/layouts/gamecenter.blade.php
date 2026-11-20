<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'گیم‌سنتر') | {{ $siteSettings['site_name'] ?? config('app.name', 'گیم‌سنتر') }}</title>
    <meta name="description" content="@yield('description', 'بازی کن، رقابت کن و رکوردت را ثبت کن.')">
    <link rel="icon" href="{{ asset('site/gamecenter/assets/img/logo/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/gamecenter.css') }}">
    @stack('styles')
</head>
<body>
    <button class="scroll__top scroll-to-target" data-target="html" aria-label="بازگشت به بالا"><i class="flaticon-right-arrow"></i></button>
    @include('site.partials.header')
    <main class="main--area">
        @yield('hero')
        @if (session('status'))
            <div class="container"><div class="gc-alert">{{ session('status') }}</div></div>
        @endif
        @if ($errors->any())
            <div class="container"><div class="gc-alert gc-alert--error">{{ $errors->first() }}</div></div>
        @endif
        @yield('content')
    </main>
    @include('site.partials.footer')
    <script src="{{ asset('site/gamecenter/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('site/gamecenter/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('site/gamecenter/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
