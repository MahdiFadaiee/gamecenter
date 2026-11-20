@extends('site.layouts.gamecenter')
@section('title', 'پروفایل '.$player->name)
@section('hero') @include('site.partials.breadcrumb', ['title' => $player->name, 'subtitle' => '@'.$player->username]) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
    <div class="col-lg-4"><div class="gc-panel text-center">
        <img class="gc-avatar mb-3" src="{{ $player->avatar ? (str_starts_with($player->avatar, 'http') ? $player->avatar : asset($player->avatar)) : asset('site/gamecenter/assets/img/team/team01.png') }}" alt="">
        <h2>{{ $player->name }}</h2><p>@{{ $player->username }}</p>
        @if($player->bio)<p>{{ $player->bio }}</p>@endif
        <div class="gc-tag">{{ intdiv($player->playedMinutes(), 60) }} ساعت بازی ثبت‌شده</div>
    </div></div>
    <div class="col-lg-8">
        <div class="gc-panel mb-4"><h3>جام‌های ثبت‌نام‌شده</h3><ul class="list-wrap">@forelse($player->tournamentRegistrations as $registration)<li><a href="{{ route('site.tournament', $registration->tournament->slug) }}">{{ $registration->tournament->name }}</a> — {{ $registration->tournament->game?->title }}</li>@empty<li>هنوز در جامی ثبت‌نام نکرده است.</li>@endforelse</ul></div>
        <div class="gc-panel mb-4"><h3>زمان‌های بازی اخیر</h3><ul class="list-wrap">@forelse($sessions as $session)<li>{{ $session->game?->title ?? 'بازی آزاد' }} — {{ $session->duration_minutes }} دقیقه</li>@empty<li>زمان بازی ثبت‌شده‌ای ندارد.</li>@endforelse</ul></div>
        <div class="gc-panel"><h3>جایزه‌ها</h3><ul class="list-wrap">@forelse($awards as $award)<li>{{ $award->rule->name }} — {{ intdiv($award->reward_minutes, 60) }} ساعت — {{ $award->status === 'redeemed' ? 'استفاده‌شده' : 'آماده دریافت' }}</li>@empty<li>هنوز جایزه‌ای دریافت نکرده است.</li>@endforelse</ul></div>
    </div>
</div></div></section>
@endsection
