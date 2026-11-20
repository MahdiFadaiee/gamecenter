@extends('site.layouts.gamecenter')
@section('title', 'خانه')
@section('hero')
<section class="slider__area">
    <div class="container"><div class="row align-items-center">
        <div class="col-lg-7">
            <span class="gc-kicker">GAME CENTER</span>
            <h1>بازی کن، <span>رقابت کن</span>، جایزه بگیر</h1>
            <p class="mb-4">بازی محبوبت را انتخاب کن، در جام‌های گیم‌سنتر شرکت کن و با هر ساعت بازی به جایزه نزدیک‌تر شو.</p>
            <a class="gc-button" href="{{ route('site.games') }}">دیدن بازی‌ها</a>
            <a class="gc-button gc-button--outline" href="{{ route('site.tournaments') }}">جام‌های پیش‌رو</a>
        </div>
        <div class="col-lg-5 d-none d-lg-block text-center"><img src="{{ asset('site/gamecenter/assets/img/slider/slider_img01.png') }}" alt="بازی‌های گیم‌سنتر" class="img-fluid"></div>
    </div></div>
</section>
@endsection
@section('content')
<section class="gc-section"><div class="container">
    <div class="gc-section-title"><div><span class="gc-kicker">ARCADE</span><h2>بازی‌های سنتر</h2></div><a href="{{ route('site.games') }}">همه بازی‌ها ←</a></div>
    <div class="row">@forelse($games as $game) @include('site.partials.game-card', ['game' => $game]) @empty<div class="col-12"><div class="gc-empty">به‌زودی بازی‌ها معرفی می‌شوند.</div></div>@endforelse</div>
</div></section>
<section class="gc-section gc-section--dark"><div class="container">
    <div class="gc-section-title"><div><span class="gc-kicker">COMPETE</span><h2>جام‌های پیش‌رو</h2></div><a href="{{ route('site.tournaments') }}">همه جام‌ها ←</a></div>
    <div class="row">@forelse($tournaments as $tournament) @include('site.partials.tournament-card', ['tournament' => $tournament]) @empty<div class="col-12"><div class="gc-empty">جام تازه‌ای اعلام نشده است.</div></div>@endforelse</div>
</div></section>
<section class="gc-section"><div class="container">
    <div class="gc-section-title"><div><span class="gc-kicker">MATCH DAY</span><h2>برنامه و نتیجه‌ها</h2></div><a href="{{ route('site.schedule') }}">برنامه کامل ←</a></div>
    <div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>جام</th><th>بازیکن ۱</th><th>نتیجه</th><th>بازیکن ۲</th><th>زمان</th></tr></thead><tbody>
    @forelse($matches as $match)<tr><td>{{ $match->tournament?->name }}</td><td>{{ $match->playerOne?->name ?? 'به‌زودی' }}</td><td>{{ $match->score_one ?? '—' }} : {{ $match->score_two ?? '—' }}</td><td>{{ $match->playerTwo?->name ?? 'به‌زودی' }}</td><td>{{ $match->scheduled_at?->format('Y/m/d H:i') ?? 'تعیین نشده' }}</td></tr>@empty<tr><td colspan="5">مسابقه‌ای ثبت نشده است.</td></tr>@endforelse
    </tbody></table></div>
</div></section>
<section class="gc-section gc-section--dark"><div class="container">
    <div class="gc-section-title"><div><span class="gc-kicker">LEADERBOARD</span><h2>بازیکن‌های پر‌ساعت</h2></div><a href="{{ route('site.team') }}">دیدن بازیکن‌ها ←</a></div>
    <div class="row">@forelse($players as $index => $player)<div class="col-lg-4 col-md-6 mb-3"><a class="gc-panel d-flex align-items-center gap-3" href="{{ route('site.player', $player->username) }}"><span class="gc-tag">#{{ $index + 1 }}</span><div><strong>{{ $player->name }}</strong><div class="gc-meta mb-0">{{ intdiv((int)$player->play_sessions_sum_duration_minutes, 60) }} ساعت بازی</div></div></a></div>@empty<div class="col-12"><div class="gc-empty">با ثبت زمان بازی، اولین نفر جدول شو.</div></div>@endforelse</div>
</div></section>
<section class="gc-section"><div class="container">
    <div class="gc-section-title"><div><span class="gc-kicker">FROM THE BLOG</span><h2>تازه‌های بلاگ</h2></div><a href="{{ route('site.blog') }}">همه مقاله‌ها ←</a></div>
    <div class="row">@forelse($posts as $post) @include('site.partials.blog-card', ['post' => $post]) @empty<div class="col-12"><div class="gc-empty">مقاله‌ها به‌زودی منتشر می‌شوند.</div></div>@endforelse</div>
</div></section>
@endsection
