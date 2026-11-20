@extends('site.layouts.gamecenter')
@section('title', 'ورود')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'ورود بازیکن', 'subtitle' => 'به حساب گیم‌سنتر وارد شو.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><form class="gc-panel gc-form mx-auto" style="max-width:560px" method="POST" action="{{ route('login') }}">@csrf
@if(session('status'))<div class="gc-alert">{{ session('status') }}</div>@endif
<label for="email">ایمیل</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username">
<label for="password">رمز عبور</label><input id="password" name="password" type="password" required autocomplete="current-password">
<label class="gc-check"><input type="checkbox" name="remember"> مرا به خاطر بسپار</label>
<button class="gc-button">ورود</button>
@if(Route::has('password.request'))<p class="mt-3"><a href="{{ route('password.request') }}">رمز عبورت را فراموش کردی؟</a></p>@endif
<p class="mt-3">حساب نداری؟ <a href="{{ route('register') }}">عضو شو</a></p>
</form></div></section>
@endsection
