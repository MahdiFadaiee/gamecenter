@extends('admin.layouts.gamecenter')
@section('title', $user->exists ? 'ویرایش عضو' : 'ثبت عضو')
@section('content')
<h1>{{ $user->exists ? 'ویرایش عضو' : 'ثبت عضو جدید' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $user->exists ? route('admin.gamecenter.members.update',$user) : route('admin.gamecenter.members.store') }}">@csrf @if($user->exists) @method('PATCH') @endif
<label>نام و نام خانوادگی</label><input name="name" value="{{ old('name',$user->name) }}" required>
<label>نام کاربری</label><input name="username" value="{{ old('username',$user->username) }}" required>
<label>ایمیل</label><input type="email" name="email" value="{{ old('email',$user->email) }}" required>
<label>موبایل</label><input name="mobile" value="{{ old('mobile',$user->mobile) }}">
<label>رمز عبور {{ $user->exists ? '(برای تغییر وارد کن)' : '' }}</label><input type="password" name="password" {{ $user->exists ? '' : 'required' }} autocomplete="new-password">
<label>تکرار رمز عبور</label><input type="password" name="password_confirmation" {{ $user->exists ? '' : 'required' }} autocomplete="new-password">
<label>درباره عضو</label><textarea name="bio">{{ old('bio',$user->bio) }}</textarea>
<label class="gc-check"><input type="checkbox" name="status" value="1" @checked(old('status',$user->exists ? $user->status : true))> عضویت فعال</label>
<button class="gc-button">ذخیره عضو</button></form>
@endsection
