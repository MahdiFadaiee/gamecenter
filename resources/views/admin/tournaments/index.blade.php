@extends('admin.layouts.gamecenter')
@section('title', 'جام‌ها')
@section('content')
<div class="gc-section-title"><h1>جام‌ها و کاپ‌ها</h1><a class="gc-button" href="{{ route('admin.gamecenter.tournaments.create') }}">ساخت جام</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>نام</th><th>بازی</th><th>زمان</th><th>شرکت‌کننده</th><th>وضعیت</th><th></th></tr></thead><tbody>
@forelse($tournaments as $tournament)<tr><td>{{ $tournament->name }}</td><td>{{ $tournament->game?->title ?? 'آزاد' }}</td><td>{{ $tournament->starts_at?->format('Y/m/d H:i') ?? '—' }}</td><td>{{ $tournament->registrations_count }}</td><td>{{ $tournament->status }}</td><td><a href="{{ route('admin.gamecenter.tournaments.edit',$tournament) }}">ویرایش</a></td></tr>@empty<tr><td colspan="6">جامی ساخته نشده.</td></tr>@endforelse
</tbody></table>{{ $tournaments->links() }}</div>
@endsection
