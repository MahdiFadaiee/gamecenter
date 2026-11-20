@extends('site.layouts.gamecenter')
@section('title', 'تماس با ما')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'تماس با گیم‌سنتر', 'subtitle' => 'برای هماهنگی جام‌ها، همکاری یا پشتیبانی پیام بفرست.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
    <div class="col-lg-5"><div class="gc-panel"><h2>گیم‌سنتر</h2><p>برای هماهنگی جام‌ها، همکاری یا پشتیبانی پیام بفرست.</p><p><a href="{{ route('site.games') }}">بازی‌ها</a> · <a href="{{ route('site.tournaments') }}">جام‌ها</a></p></div></div>
    <div class="col-lg-7"><form class="gc-panel gc-form" method="POST" action="{{ route('site.contact.send') }}">@csrf
        <label for="name">نام</label><input id="name" name="name" value="{{ old('name') }}" required>
        <label for="email">ایمیل</label><input id="email" type="email" name="email" value="{{ old('email') }}" required>
        <label for="subject">موضوع</label><input id="subject" name="subject" value="{{ old('subject') }}">
        <label for="message">پیام</label><textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
        <button class="gc-button">ارسال پیام</button>
    </form></div>
</div></div></section>
@endsection
