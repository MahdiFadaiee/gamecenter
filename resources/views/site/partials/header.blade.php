<header>
    <div id="sticky-header" class="tg-header__area">
        <div class="container custom-container">
            <div class="row"><div class="col-12">
                <div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
                <div class="tgmenu__wrap">
                    <nav class="tgmenu__nav">
                        <div class="logo"><a href="{{ route('site.home') }}"><span class="gc-brand__icon"><i class="fas fa-gamepad"></i></span><strong class="gc-brand__name">گیم‌سنتر</strong></a></div>
                        <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-xl-flex">
                            <ul class="navigation">
                                <li><a href="{{ route('site.home') }}">خانه</a></li>
                                <li><a href="{{ route('site.games') }}">بازی‌ها</a></li>
                                <li><a href="{{ route('site.tournaments') }}">جام‌ها</a></li>
                                <li><a href="{{ route('site.schedule') }}">برنامه و نتیجه‌ها</a></li>
                                <li><a href="{{ route('site.blog') }}">بلاگ</a></li>
                                <li><a href="{{ route('site.team') }}">بازیکن‌ها</a></li>
                                <li><a href="{{ route('site.contact') }}">تماس</a></li>
                            </ul>
                        </div>
                        <div class="tgmenu__action d-none d-md-block">
                            <ul class="list-wrap">
                                @auth
                                    <li class="header-btn"><a class="tg-border-btn" href="{{ route('member.dashboard') }}">پنل من</a></li>
                                @else
                                    <li><a class="gc-header-login" href="{{ route('login') }}">ورود</a></li>
                                    <li class="header-btn"><a class="tg-border-btn" href="{{ route('register') }}">عضویت</a></li>
                                @endauth
                            </ul>
                        </div>
                    </nav>
                </div>
                <div class="tgmobile__menu">
                    <nav class="tgmobile__menu-box">
                        <div class="close-btn"><i class="flaticon-swords-in-cross-arrangement"></i></div>
                        <div class="nav-logo"><a href="{{ route('site.home') }}"><span class="gc-brand__icon"><i class="fas fa-gamepad"></i></span><strong class="gc-brand__name">گیم‌سنتر</strong></a></div>
                        <div class="tgmobile__menu-outer"></div>
                        <div class="gc-mobile-account">
                            @auth
                                <a class="gc-button" href="{{ route('member.dashboard') }}">پنل من</a>
                            @else
                                <a href="{{ route('login') }}">ورود</a>
                                <a class="gc-button" href="{{ route('register') }}">عضویت</a>
                            @endauth
                        </div>
                    </nav>
                </div>
                <div class="tgmobile__menu-backdrop"></div>
            </div></div>
        </div>
    </div>
</header>
