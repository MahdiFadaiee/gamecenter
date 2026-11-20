@extends('site.layouts.gamecenter')
@section('title', 'پنل بازیکن')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'سلام '.$user->name, 'subtitle' => 'پنل بازیکن و زمان بازی شما']) @endsection
@section('content')
<section class="gc-section"><div class="container">
    <div class="row mb-4">
        <div class="col-md-4 mb-3"><div class="gc-stat"><span>زمان ثبت‌شده</span><strong>{{ intdiv($playedMinutes,60) }}:{{ str_pad($playedMinutes%60,2,'0',STR_PAD_LEFT) }}</strong>ساعت و دقیقه</div></div>
        <div class="col-md-4 mb-3"><div class="gc-stat"><span>جایزه‌های دریافت‌شده</span><strong>{{ $user->rewardAwards()->count() }}</strong>جایزه</div></div>
        <div class="col-md-4 mb-3"><div class="gc-stat"><span>پروفایل عمومی</span><strong style="font-size:1.3rem"><a href="{{ route('site.player',$user->username) }}">مشاهده پروفایل ←</a></strong>{{ '@'.$user->username }}</div></div>
    </div>
    @if($rewardRule)<div class="gc-panel mb-4"><div class="d-flex justify-content-between"><h3>{{ $rewardRule->name }}</h3><span>{{ intdiv($toNextReward,60) }} ساعت تا جایزه بعدی</span></div><div class="gc-progress"><span style="width:{{ $progress }}%"></span></div><small>هر {{ intdiv($rewardRule->threshold_minutes,60) }} ساعت، {{ intdiv($rewardRule->reward_minutes,60) }} ساعت بازی رایگان</small></div>@endif
    <div class="row">
        <div class="col-lg-6 mb-4"><div class="gc-panel h-100"><h3>ثبت زمان بازی</h3>
        @if($activeSession)
            <p>نشست از {{ $activeSession->started_at->format('H:i') }} شروع شده است. {{ $activeSession->game?->title ?? 'بازی آزاد' }}</p>
            <form method="POST" action="{{ route('member.sessions.finish',$activeSession) }}">@csrf @method('PATCH')<button class="gc-button">پایان نشست و ثبت زمان</button></form>
        @else
            <form class="gc-form" method="POST" action="{{ route('member.sessions.start') }}">@csrf
                <label for="game_id">بازی</label><select id="game_id" name="game_id"><option value="">بازی آزاد</option>@foreach($games as $game)<option value="{{ $game->id }}">{{ $game->title }}</option>@endforeach</select>
                <button class="gc-button">شروع ثبت زمان بازی</button>
            </form>
            <small>برای بازی حضوری، مسئول گیم‌سنتر می‌تواند زمانت را در سیستم ثبت کند.</small>
        @endif</div></div>
        <div class="col-lg-6 mb-4"><div class="gc-panel h-100"><h3>جوایز من</h3>@forelse($awards as $award)<div class="d-flex justify-content-between align-items-center border-bottom py-2"><span>{{ $award->rule?->name }} — {{ intdiv($award->reward_minutes,60) }} ساعت</span>@if($award->status==='available')<form method="POST" action="{{ route('member.rewards.redeem',$award) }}">@csrf<button class="gc-button gc-button--small">ثبت استفاده</button></form>@else<span class="gc-tag">استفاده‌شده</span>@endif</div>@empty<p>با ثبت زمان بازی، جایزه‌ها اینجا نمایش داده می‌شوند.</p>@endforelse</div></div>
    </div>
    <div class="gc-panel mb-4"><h3>نشست‌های اخیر</h3><div class="table-responsive"><table class="gc-table"><thead><tr><th>بازی</th><th>شروع</th><th>مدت</th><th>وضعیت</th></tr></thead><tbody>@forelse($sessions as $session)<tr><td>{{ $session->game?->title ?? 'بازی آزاد' }}</td><td>{{ $session->started_at->format('Y/m/d H:i') }}</td><td>{{ $session->ended_at ? intdiv($session->duration_minutes,60).' ساعت '.($session->duration_minutes%60).' دقیقه' : 'در حال اجرا' }}</td><td>{{ $session->ended_at ? 'ثبت‌شده' : 'باز' }}</td></tr>@empty<tr><td colspan="4">هنوز زمانی ثبت نشده.</td></tr>@endforelse</tbody></table></div></div>
    <div class="gc-panel"><div class="gc-section-title"><h3>جام‌های در حال ثبت‌نام</h3><a href="{{ route('site.tournaments') }}">همه جام‌ها ←</a></div><div class="row">@forelse($tournaments as $tournament)<div class="col-md-6 mb-3"><a href="{{ route('site.tournament',$tournament->slug) }}">{{ $tournament->name }} — {{ $tournament->starts_at?->format('Y/m/d') }}</a></div>@empty<p>جام بازی‌ای باز نیست.</p>@endforelse</div></div>
</div></section>
@endsection
