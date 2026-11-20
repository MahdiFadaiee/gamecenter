@extends('admin.layouts.gamecenter')
@section('title', $game->exists ? 'ویرایش بازی' : 'بازی تازه')
@section('content')
<h1>{{ $game->exists ? 'ویرایش بازی' : 'افزودن بازی' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $game->exists ? route('admin.gamecenter.games.update',$game) : route('admin.gamecenter.games.store') }}">
@csrf @if($game->exists) @method('PATCH') @endif
<label>نام بازی</label><input name="title" value="{{ old('title',$game->title) }}" required>
<label>نشانی کوتاه (slug)</label><input name="slug" value="{{ old('slug',$game->slug) }}" required>
<label>سبک بازی</label><input name="genre" value="{{ old('genre',$game->genre) }}">
<label>پلتفرم</label><input name="platform" value="{{ old('platform',$game->platform) }}">
<label>سازنده</label><input name="developer" value="{{ old('developer',$game->developer) }}">
<label>آدرس تصویر یا مسیر فایل</label><input name="image" value="{{ old('image',$game->image) }}">
<label>معرفی کوتاه</label><textarea name="summary">{{ old('summary',$game->summary) }}</textarea>
<label>توضیحات</label><textarea name="description">{{ old('description',$game->description) }}</textarea>
<label class="gc-check"><input type="checkbox" name="featured" value="1" @checked(old('featured',$game->featured))> نمایش ویژه</label>
<label class="gc-check"><input type="checkbox" name="active" value="1" @checked(old('active',$game->exists ? $game->active : true))> در سایت نمایش داده شود</label>
<button class="gc-button">ذخیره</button></form>
@endsection
