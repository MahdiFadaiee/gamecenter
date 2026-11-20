<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'حساب کاربری') | گیم‌سنتر</title>
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/gamecenter.css') }}">
</head>
<body>
    @include('site.partials.header')
    <main class="main--area gc-section"><div class="container">
        @if (session('status'))<div class="gc-alert">{{ session('status') }}</div>@endif
        @if ($errors->any())<div class="gc-alert gc-alert--error">{{ $errors->first() }}</div>@endif
        {{ $slot }}
    </div></main>
    @include('site.partials.footer')
    <script src="{{ asset('site/gamecenter/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('site/gamecenter/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('site/gamecenter/assets/js/main.js') }}"></script>
</body>
</html>
