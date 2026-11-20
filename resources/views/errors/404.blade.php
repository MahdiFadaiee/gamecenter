@extends('site.layouts.gamecenter')
@section('title', 'صفحه پیدا نشد')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'صفحه پیدا نشد', 'subtitle' => 'نشانی موردنظر در گیم‌سنتر وجود ندارد.']) @endsection
@section('content')
<section class="gc-section"><div class="container text-center"><div class="gc-panel mx-auto" style="max-width:680px"><strong class="gc-kicker">404</strong><h1>این صفحه پیدا نشد</h1><p>ممکن است نشانی اشتباه باشد یا صفحه جابه‌جا شده باشد.</p><a class="gc-button" href="{{ route('site.home') }}">رفتن به صفحه اصلی</a></div></div></section>
@endsection
