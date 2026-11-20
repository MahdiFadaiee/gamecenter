@extends('admin.layouts.gamecenter')
@section('title', 'ثبت زمان حضوری')
@section('content')
<h1>ثبت زمان بازی حضوری</h1>
<p class="gc-muted">زمان شروع و پایان را وارد کن. جوایز واجد شرایط پس از ثبت، خودکار فعال می‌شوند.</p>
<form class="gc-panel gc-form" method="POST" action="{{ route('admin.gamecenter.sessions.store') }}">@csrf
<label>عضو</label><select name="user_id" required><option value="">انتخاب عضو</option>@foreach($members as $member)<option value="{{ $member->id }}">{{ $member->name }} — {{ $member->username }}</option>@endforeach</select>
<label>بازی</label><select name="game_id"><option value="">بازی آزاد</option>@foreach($games as $game)<option value="{{ $game->id }}">{{ $game->title }}</option>@endforeach</select>
<div class="row"><div class="col-md-6"><label>زمان شروع</label><input type="datetime-local" name="started_at" required></div><div class="col-md-6"><label>زمان پایان</label><input type="datetime-local" name="ended_at" required></div></div>
<label>یادداشت</label><textarea name="note"></textarea>
<button class="gc-button">ثبت زمان و محاسبه جایزه</button></form>
@endsection
