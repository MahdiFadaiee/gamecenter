@extends('admin.layouts.gamecenter')
@section('title', $page->exists ? 'ویرایش صفحه' : 'صفحه تازه')
@section('content')
<h1>{{ $page->exists ? 'ویرایش صفحه' : 'ساخت صفحه' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $page->exists ? route('admin.gamecenter.pages.update',$page) : route('admin.gamecenter.pages.store') }}">@csrf @if($page->exists) @method('PATCH') @endif
<label>عنوان صفحه</label><input name="title" value="{{ old('title',$page->title) }}" required>
<label>نشانی کوتاه (اختیاری)</label><input name="slug" value="{{ old('slug',$page->slug) }}">
<label>متن صفحه</label><textarea name="body" required>{{ old('body',$page->body) }}</textarea>
<label>وضعیت</label><select name="status"><option value="draft" @selected(old('status',$page->status ?: 'draft')==='draft')>پیش‌نویس</option><option value="published" @selected(old('status',$page->status)==='published')>منتشرشده</option></select>
<button class="gc-button">ذخیره صفحه</button></form>
@endsection
