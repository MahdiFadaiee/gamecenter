@extends('admin.layouts.gamecenter')
@section('title', 'اعضا')
@section('content')
<div class="gc-section-title"><h1>اعضا</h1><a class="gc-button" href="{{ route('admin.gamecenter.members.create') }}">ثبت عضو جدید</a></div>
<form class="gc-search" method="GET"><input name="q" value="{{ request('q') }}" placeholder="نام، ایمیل یا نام کاربری"><button class="gc-button gc-button--small">جستجو</button></form>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>نام</th><th>نام کاربری</th><th>ایمیل</th><th>زمان بازی</th><th>وضعیت</th><th></th></tr></thead><tbody>
@forelse($members as $member)<tr><td>{{ $member->name }}</td><td><a href="{{ route('site.player',$member->username) }}">@{{ $member->username }}</a></td><td>{{ $member->email }}</td><td>{{ intdiv($member->playedMinutes(),60) }} ساعت</td><td>{{ $member->status ? 'فعال' : 'غیرفعال' }}</td><td><a href="{{ route('admin.gamecenter.members.edit',$member) }}">ویرایش</a><form class="d-inline" method="POST" action="{{ route('admin.gamecenter.members.status',$member) }}">@csrf @method('PATCH')<button class="gc-link">{{ $member->status ? 'غیرفعال‌سازی' : 'فعال‌سازی' }}</button></form></td></tr>@empty<tr><td colspan="6">عضوی پیدا نشد.</td></tr>@endforelse
</tbody></table>{{ $members->links() }}</div>
@endsection
