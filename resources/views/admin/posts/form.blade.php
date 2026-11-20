@extends('admin.layouts.gamecenter')
@section('title', $post->exists ? 'ویرایش مقاله' : 'مقاله تازه')
@section('content')
<h1>{{ $post->exists ? 'ویرایش مقاله' : 'نوشتن مقاله' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $post->exists ? route('admin.gamecenter.posts.update',$post) : route('admin.gamecenter.posts.store') }}">@csrf @if($post->exists) @method('PATCH') @endif
<label>عنوان</label><input name="title" value="{{ old('title',$post->title) }}" required>
<label>نشانی کوتاه (اختیاری)</label><input name="slug" value="{{ old('slug',$post->slug) }}">
<label>تصویر کاور</label><input name="cover_image" value="{{ old('cover_image',$post->cover_image) }}">
<label>خلاصه</label><textarea name="excerpt">{{ old('excerpt',$post->excerpt) }}</textarea>
<label>متن مقاله</label><textarea name="body" required>{{ old('body',$post->body) }}</textarea>
<label>وضعیت</label><select name="status"><option value="draft" @selected(old('status',$post->status ?: 'draft')==='draft')>پیش‌نویس</option><option value="published" @selected(old('status',$post->status)==='published')>منتشرشده</option></select>
<label>تاریخ انتشار</label><input type="datetime-local" name="published_at" value="{{ old('published_at',$post->published_at?->format('Y-m-d\\TH:i')) }}">
<button class="gc-button">ذخیره مقاله</button></form>
@endsection
