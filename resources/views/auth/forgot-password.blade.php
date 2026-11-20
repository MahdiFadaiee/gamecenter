<x-guest-layout>
    <div class="auth-heading"><span class="auth-heading__eyebrow"><i class="ti-key"></i> بازیابی حساب</span><h2>گذرواژه‌تان را فراموش کرده‌اید؟</h2><p>ایمیل حساب را وارد کنید تا پیوند ساخت گذرواژهٔ تازه برایتان ارسال شود.</p></div>
    <x-auth-session-status class="auth-status" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf
        <div class="auth-field"><label for="email">ایمیل</label><input id="email" class="form-control auth-ltr-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"><x-input-error :messages="$errors->get('email')" /></div>
        <button type="submit">ارسال پیوند بازیابی</button>
    </form>
</x-guest-layout>
