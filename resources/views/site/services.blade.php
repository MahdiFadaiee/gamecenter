@extends('site.layouts.gamecenter')
@section('title', 'جایزه‌های زمان بازی')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'جایزه‌های زمان بازی', 'subtitle' => 'با ثبت ساعت‌های بازی، جایزه‌های گیم‌سنتر را دریافت کن.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
@forelse($rules as $rule)<div class="col-lg-4 mb-4"><div class="gc-panel h-100"><span class="gc-kicker">PLAY & EARN</span><h2>{{ $rule->name }}</h2><p>پس از {{ intdiv($rule->threshold_minutes, 60) }} ساعت بازی</p><strong>{{ intdiv($rule->reward_minutes, 60) }} ساعت بازی رایگان</strong></div></div>@empty<div class="col-12"><div class="gc-empty">قانون جایزه‌ای تعریف نشده است.</div></div>@endforelse
</div></div></section>
@endsection
