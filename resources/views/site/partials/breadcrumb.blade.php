<section class="breadcrumb-area" style="background-image:url('{{ asset('site/gamecenter/assets/img/bg/breadcrumb_bg.jpg') }}')">
    <div class="container"><div class="row"><div class="col-12">
        <div class="breadcrumb__content"><h1 class="title">{{ $title }}</h1><p>{{ $subtitle ?? 'بازی کن، رقابت کن و جایزه بگیر.' }}</p>
        <nav aria-label="مسیر صفحه"><a href="{{ route('site.home') }}">خانه</a><span> / {{ $title }}</span></nav></div>
    </div></div></div>
</section>
