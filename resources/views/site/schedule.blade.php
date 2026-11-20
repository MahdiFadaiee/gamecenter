@extends('site.layouts.gamecenter')
@section('title', 'برنامه مسابقه‌ها')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'برنامه و نتیجه مسابقه‌ها', 'subtitle' => 'بازی‌های پیش‌رو و نتیجه دیدارهای برگزارشده.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>جام</th><th>مرحله</th><th>بازیکن ۱</th><th>نتیجه</th><th>بازیکن ۲</th><th>برنده</th><th>زمان</th></tr></thead><tbody>
@forelse($matches as $match)<tr><td><a href="{{ route('site.tournament', $match->tournament->slug) }}">{{ $match->tournament->name }}</a></td><td>{{ $match->round ?: '—' }}</td><td>{{ $match->playerOne?->name ?? 'به‌زودی' }}</td><td>{{ $match->score_one ?? '—' }} : {{ $match->score_two ?? '—' }}</td><td>{{ $match->playerTwo?->name ?? 'به‌زودی' }}</td><td>{{ $match->winner?->name ?? '—' }}</td><td>{{ $match->scheduled_at?->format('Y/m/d H:i') ?? 'تعیین نشده' }}</td></tr>@empty<tr><td colspan="7">مسابقه‌ای ثبت نشده.</td></tr>@endforelse
</tbody></table></div>{{ $matches->links() }}</div></section>
@endsection
