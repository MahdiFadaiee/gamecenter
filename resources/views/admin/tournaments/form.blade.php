@extends('admin.layouts.gamecenter')
@section('title', $tournament->exists ? 'ویرایش جام' : 'ساخت جام')
@section('content')
<h1>{{ $tournament->exists ? 'ویرایش جام' : 'ساخت جام' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $tournament->exists ? route('admin.gamecenter.tournaments.update',$tournament) : route('admin.gamecenter.tournaments.store') }}">@csrf @if($tournament->exists) @method('PATCH') @endif
<label>نام جام</label><input name="name" value="{{ old('name',$tournament->name) }}" required>
<label>نشانی کوتاه</label><input name="slug" value="{{ old('slug',$tournament->slug) }}" required>
<label>بازی</label><select name="game_id"><option value="">آزاد</option>@foreach($games as $game)<option value="{{ $game->id }}" @selected(old('game_id',$tournament->game_id)==$game->id)>{{ $game->title }}</option>@endforeach</select>
<label>وضعیت</label><select name="status">@foreach(['draft'=>'پیش‌نویس','open'=>'ثبت‌نام باز','active'=>'در جریان','completed'=>'پایان‌یافته'] as $value=>$label)<option value="{{ $value }}" @selected(old('status',$tournament->status ?: 'draft')===$value)>{{ $label }}</option>@endforeach</select>
<label>تصویر کاور (آدرس یا مسیر)</label><input name="cover_image" value="{{ old('cover_image',$tournament->cover_image) }}">
<label>شروع</label><input type="datetime-local" name="starts_at" value="{{ old('starts_at',$tournament->starts_at?->format('Y-m-d\\TH:i')) }}">
<label>پایان</label><input type="datetime-local" name="ends_at" value="{{ old('ends_at',$tournament->ends_at?->format('Y-m-d\\TH:i')) }}">
<label>حداکثر شرکت‌کننده</label><input type="number" min="2" name="max_participants" value="{{ old('max_participants',$tournament->max_participants) }}">
<label>جایزه</label><input name="prize" value="{{ old('prize',$tournament->prize) }}">
<label>توضیحات</label><textarea name="description">{{ old('description',$tournament->description) }}</textarea>
<button class="gc-button">ذخیره جام</button></form>
@endsection
