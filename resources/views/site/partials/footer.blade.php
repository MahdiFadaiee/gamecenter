<footer class="footer__area">
    <div class="footer__top-wrap">
        <div class="container"><div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footer-widget">
                    <div class="footer-logo"><a href="{{ route('site.home') }}"><span class="gc-brand__icon"><i class="fas fa-gamepad"></i></span><strong class="gc-brand__name">گیم‌سنتر</strong></a></div>
                    <p>پاتوق بازیکن‌ها؛ بازی کن، رقابت کن و زمان بازی‌ات را به جایزه تبدیل کن.</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="footer-widget"><h4 class="fw-title">گیم‌سنتر</h4><ul class="list-wrap">
                    <li><a href="{{ route('site.about') }}">درباره ما</a></li><li><a href="{{ route('site.services') }}">جایزه‌ها</a></li><li><a href="{{ route('site.contact') }}">تماس با ما</a></li>
                </ul></div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget"><h4 class="fw-title">رقابت</h4><ul class="list-wrap">
                    <li><a href="{{ route('site.games') }}">بازی‌ها</a></li><li><a href="{{ route('site.tournaments') }}">جام‌ها</a></li><li><a href="{{ route('site.schedule') }}">برنامه مسابقه‌ها</a></li>
                </ul></div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget"><h4 class="fw-title">بازیکن‌ها</h4><ul class="list-wrap">
                    @auth <li><a href="{{ route('member.dashboard') }}">پنل من</a></li><li><a href="{{ route('member.profile.edit') }}">ویرایش پروفایل</a></li>
                    @else <li><a href="{{ route('register') }}">ساخت حساب</a></li><li><a href="{{ route('login') }}">ورود به حساب</a></li> @endauth
                </ul></div>
            </div>
        </div></div>
    </div>
    <div class="copyright__wrap"><div class="container"><div class="row"><div class="col-12">
        <div class="copyright__text text-center"><p>© {{ date('Y') }} گیم‌سنتر — بازی خوب، رقابت سالم</p></div>
    </div></div></div></div>
</footer>
