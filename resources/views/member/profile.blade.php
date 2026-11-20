@extends('site.layouts.gamecenter')
@section('title', 'ویرایش پروفایل')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'ویرایش پروفایل']) @endsection
@section('content')
<section class="gc-section"><div class="container"><form class="gc-panel gc-form mx-auto" style="max-width:760px" method="POST" action="{{ route('member.profile.update') }}">@csrf @method('PATCH')
<label for="name">نام نمایشی</label><input id="name" name="name" value="{{ old('name',$user->name) }}" required>
<label for="username">نام کاربری و لینک پروفایل</label><input id="username" name="username" value="{{ old('username',$user->username) }}" required>
<label for="mobile">موبایل</label><input id="mobile" name="mobile" value="{{ old('mobile',$user->mobile) }}">
<label for="avatar">آدرس تصویر پروفایل</label><input id="avatar" name="avatar" value="{{ old('avatar',$user->avatar) }}">
<label for="bio">درباره من</label><textarea id="bio" name="bio">{{ old('bio',$user->bio) }}</textarea>
<button class="gc-button">ذخیره پروفایل</button></form></div></section>
@endsection
