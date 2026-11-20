@extends('admin.layouts.gamecenter')
@section('title', 'زمان بازی')
@section('content')
<div class="gc-section-title"><h1>زمان بازی اعضا</h1><a class="gc-button" href="{{ route('admin.gamecenter.sessions.create') }}">ثبت زمان حضوری</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>عضو</th><th>بازی</th><th>شروع</th><th>پایان</th><th>مدت</th><th>ثبت‌کننده</th></tr></thead><tbody>
@forelse($sessions as $session)<tr><td>{{ $session->user->name }}</td><td>{{ $session->game?->title ?? 'بازی آزاد' }}</td><td>{{ $session->started_at->format('Y/m/d H:i') }}</td><td>{{ $session->ended_at?->format('Y/m/d H:i') ?? 'در حال اجرا' }}</td><td>{{ $session->ended_at ? intdiv($session->duration_minutes,60).' ساعت '.($session->duration_minutes%60).' دقیقه' : '—' }}</td><td>{{ $session->recorder?->name ?? 'ثبت خودکار' }}</td></tr>@empty<tr><td colspan="6">نشستی ثبت نشده.</td></tr>@endforelse
</tbody></table>{{ $sessions->links() }}</div>
@endsection
