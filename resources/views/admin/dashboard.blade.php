@extends('admin.layouts.gamecenter')
@section('title', 'نمای کلی')
@section('content')
<h1>مدیریت گیم‌سنتر</h1><p class="gc-muted">اعضا، رقابت‌ها و زمان بازی را از اینجا مدیریت کن.</p>
<div class="row my-4">
    <div class="col-md-3 mb-3"><div class="gc-stat"><span>اعضای فعال</span><strong>{{ number_format($stats['members']) }}</strong></div></div>
    <div class="col-md-3 mb-3"><div class="gc-stat"><span>بازی‌های سایت</span><strong>{{ number_format($stats['games']) }}</strong></div></div>
    <div class="col-md-3 mb-3"><div class="gc-stat"><span>جام‌های باز</span><strong>{{ number_format($stats['tournaments']) }}</strong></div></div>
    <div class="col-md-3 mb-3"><div class="gc-stat"><span>ساعت ثبت‌شده</span><strong>{{ number_format((int)floor($stats['playedMinutes']/60)) }}</strong></div></div>
</div>
<div class="row">
    <div class="col-lg-7 mb-4"><div class="gc-panel"><div class="gc-section-title"><h2>آخرین نشست‌ها</h2><a href="{{ route('admin.gamecenter.sessions.index') }}">همه</a></div><div class="table-responsive"><table class="gc-table"><thead><tr><th>عضو</th><th>بازی</th><th>مدت</th><th>شروع</th></tr></thead><tbody>@forelse($sessions as $session)<tr><td>{{ $session->user->name }}</td><td>{{ $session->game?->title ?? 'آزاد' }}</td><td>{{ $session->ended_at ? $session->duration_minutes.' دقیقه' : 'باز' }}</td><td>{{ $session->started_at->format('Y/m/d H:i') }}</td></tr>@empty<tr><td colspan="4">زمانی ثبت نشده.</td></tr>@endforelse</tbody></table></div></div></div>
    <div class="col-lg-5 mb-4"><div class="gc-panel"><div class="gc-section-title"><h2>مسابقه‌های پیش‌رو</h2><a href="{{ route('admin.gamecenter.matches.create') }}">ثبت مسابقه</a></div>@forelse($matches as $match)<p>{{ $match->tournament->name }}<br><small>{{ $match->playerOne?->name ?? 'بازیکن ۱' }} – {{ $match->playerTwo?->name ?? 'بازیکن ۲' }} · {{ $match->scheduled_at?->format('Y/m/d H:i') }}</small></p>@empty<p>مسابقه‌ای زمان‌بندی نشده.</p>@endforelse</div></div>
</div>
@endsection
