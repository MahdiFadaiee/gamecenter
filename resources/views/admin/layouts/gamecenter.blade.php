<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'مدیریت') | گیم‌سنتر</title>
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/gamecenter.css') }}">
    <link rel="stylesheet" href="{{ asset('site/gamecenter/admin.css') }}">
</head>
<body class="gc-admin">
<div class="gc-admin__top">
    <a href="{{ route('site.home') }}"><span class="gc-brand__icon"><i class="fas fa-gamepad"></i></span><strong class="gc-brand__name">گیم‌سنتر</strong></a>
    <div><span>{{ auth()->user()->name }}</span><form method="POST" action="{{ route('logout') }}">@csrf<button>خروج</button></form></div>
</div>
<div class="gc-admin__shell">
    <aside class="gc-admin__nav">
        <a href="{{ route('admin.gamecenter.dashboard') }}">نمای کلی</a>
        <a href="{{ route('admin.gamecenter.members.index') }}">اعضا</a>
        <a href="{{ route('admin.gamecenter.games.index') }}">بازی‌ها</a>
        <a href="{{ route('admin.gamecenter.tournaments.index') }}">جام‌ها</a>
        <a href="{{ route('admin.gamecenter.matches.index') }}">برنامه و نتیجه‌ها</a>
        <a href="{{ route('admin.gamecenter.sessions.index') }}">زمان بازی</a>
        <a href="{{ route('admin.gamecenter.rewards.index') }}">جایزه‌ها</a>
        <a href="{{ route('admin.gamecenter.posts.index') }}">بلاگ</a>
        <a href="{{ route('admin.gamecenter.pages.index') }}">صفحه‌های سایت</a>
        <a href="{{ route('admin.gamecenter.messages.index') }}">پیام‌ها</a>
        <a href="{{ route('site.home') }}">مشاهده سایت ↗</a>
    </aside>
    <main class="gc-admin__main">
        @if(session('status'))<div class="gc-alert">{{ session('status') }}</div>@endif
        @if($errors->any())<div class="gc-alert gc-alert--error">{{ $errors->first() }}</div>@endif
        @yield('content')
    </main>
</div>
</body>
</html>
