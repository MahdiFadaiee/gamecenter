@extends('site.layouts.gamecenter')
@section('title', 'ساخت حساب')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'به گیم‌سنتر بپیوند', 'subtitle' => 'حساب بساز و وارد رقابت شو.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><form class="gc-panel gc-form mx-auto" style="max-width:620px" method="POST" action="{{ route('register') }}">@csrf
<label for="name">نام و نام خانوادگی</label><input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
<label for="email">ایمیل</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
<label for="mobile">موبایل (اختیاری)</label><input id="mobile" name="mobile" value="{{ old('mobile') }}" autocomplete="tel">
<label for="password">رمز عبور</label><input id="password" name="password" type="password" required autocomplete="new-password">
<label for="password_confirmation">تکرار رمز عبور</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">
<button class="gc-button">ساخت حساب بازیکن</button>
<p class="mt-3">حساب داری؟ <a href="{{ route('login') }}">وارد شو</a></p>
</form></div></section>
@endsection
