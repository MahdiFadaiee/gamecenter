<x-guest-layout>
    <div class="auth-heading"><span class="auth-heading__eyebrow"><i class="ti-shield"></i> بررسی امنیت</span><h2>تأیید گذرواژه</h2><p>برای دسترسی به این بخش امن، گذرواژهٔ حساب را دوباره وارد کنید.</p></div>
    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf
        <div class="auth-field"><label for="password">گذرواژه</label><input id="password" class="form-control" type="password" name="password" required autocomplete="current-password"><x-input-error :messages="$errors->get('password')" /></div>
        <button type="submit">تأیید و ادامه</button>
    </form>
</x-guest-layout>
