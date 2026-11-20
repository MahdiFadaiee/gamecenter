<x-guest-layout>
    <div class="auth-heading"><span class="auth-heading__eyebrow"><i class="ti-email"></i> تأیید ایمیل</span><h2>یک گام تا تکمیل ثبت‌نام</h2><p>برای فعال‌سازی حساب، پیوندی را که به ایمیلتان فرستادیم باز کنید. اگر ایمیلی دریافت نکرده‌اید، می‌توانید دوباره درخواست ارسال بدهید.</p></div>
    @if (session('status') == 'verification-link-sent')
        <div class="auth-status" role="status">پیوند تازهٔ تأیید به ایمیل ثبت‌شدهٔ شما ارسال شد.</div>
    @endif
    <div class="auth-form">
        <form method="POST" action="{{ route('verification.send') }}">@csrf<button type="submit">ارسال دوبارهٔ ایمیل تأیید</button></form>
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="auth-secondary-button">خروج از حساب</button></form>
    </div>
</x-guest-layout>
