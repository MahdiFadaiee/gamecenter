@extends('admin.layouts.gamecenter')
@section('title', 'بازی‌ها')
@section('content')
<div class="gc-section-title"><h1>بازی‌ها</h1><a class="gc-button" href="{{ route('admin.gamecenter.games.create') }}">افزودن بازی</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>عنوان</th><th>سبک</th><th>پلتفرم</th><th>وضعیت</th><th></th></tr></thead><tbody>@forelse($games as $game)<tr><td>{{ $game->title }}</td><td>{{ $game->genre ?: '—' }}</td><td>{{ $game->platform ?: '—' }}</td><td>{{ $game->active ? 'فعال' : 'پنهان' }}</td><td><a href="{{ route('admin.gamecenter.games.edit',$game) }}">ویرایش</a></td></tr>@empty<tr><td colspan="5">بازی‌ای ثبت نشده.</td></tr>@endforelse</tbody></table>{{ $games->links() }}</div>
@endsection
