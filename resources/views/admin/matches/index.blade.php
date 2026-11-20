@extends('admin.layouts.gamecenter')
@section('title', 'برنامه و نتایج')
@section('content')
<div class="gc-section-title"><h1>برنامه مسابقه‌ها و نتایج</h1><a class="gc-button" href="{{ route('admin.gamecenter.matches.create') }}">ثبت مسابقه</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>جام</th><th>مرحله</th><th>بازیکنان</th><th>نتیجه</th><th>زمان</th><th>وضعیت</th><th></th></tr></thead><tbody>
@forelse($matches as $match)<tr><td>{{ $match->tournament->name }}</td><td>{{ $match->round }}</td><td>{{ $match->playerOne?->name ?? '—' }} / {{ $match->playerTwo?->name ?? '—' }}</td><td>{{ $match->score_one ?? '—' }} : {{ $match->score_two ?? '—' }}</td><td>{{ $match->scheduled_at?->format('Y/m/d H:i') }}</td><td>{{ $match->status }}</td><td><a href="{{ route('admin.gamecenter.matches.edit',$match) }}">ویرایش نتیجه</a></td></tr>@empty<tr><td colspan="7">مسابقه‌ای ثبت نشده.</td></tr>@endforelse
</tbody></table>{{ $matches->links() }}</div>
@endsection
