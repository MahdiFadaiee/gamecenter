@extends('site.layouts.gamecenter')
@section('title', 'بازیکن‌ها')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'بازیکن‌های گیم‌سنتر', 'subtitle' => 'پروفایل اعضا و رکورد زمان بازی را ببین.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
@forelse($players as $index => $player)<div class="col-lg-4 col-md-6 mb-4"><a class="gc-panel d-flex align-items-center gap-3 h-100" href="{{ route('site.player', $player->username) }}"><span class="gc-tag">#{{ $index + 1 }}</span><img class="gc-avatar" src="{{ $player->avatar ? (str_starts_with($player->avatar, 'http') ? $player->avatar : asset($player->avatar)) : asset('site/gamecenter/assets/img/team/team01.png') }}" alt=""><div><h3>{{ $player->name }}</h3><p>@{{ $player->username }}</p><span>{{ intdiv((int)$player->play_sessions_sum_duration_minutes,60) }} ساعت بازی</span></div></a></div>@empty<div class="col-12"><div class="gc-empty">هنوز بازیکنی ثبت نشده است.</div></div>@endforelse
</div></div></section>
@endsection
