<x-guest-layout>
    <div class="auth-heading"><span class="auth-heading__eyebrow"><i class="ti-lock"></i> امنیت حساب</span><h2>تنظیم گذرواژهٔ تازه</h2><p>برای ادامه، گذرواژهٔ جدید خود را وارد کنید.</p></div>
    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="auth-field"><label for="email">ایمیل</label><input id="email" class="form-control auth-ltr-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"><x-input-error :messages="$errors->get('email')" /></div>
        <div class="auth-field"><label for="password">گذرواژهٔ جدید</label><input id="password" class="form-control" type="password" name="password" required autocomplete="new-password"><x-input-error :messages="$errors->get('password')" /></div>
        <div class="auth-field"><label for="password_confirmation">تکرار گذرواژهٔ جدید</label><input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password"><x-input-error :messages="$errors->get('password_confirmation')" /></div>
        <button type="submit">ذخیرهٔ گذرواژه</button>
    </form>
</x-guest-layout>
