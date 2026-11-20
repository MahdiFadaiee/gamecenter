@extends('site.layouts.gamecenter')
@section('title', 'جام‌ها')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'جام‌ها و کاپ‌ها', 'subtitle' => 'برای جام بعدی ثبت‌نام کن و نتیجه‌ها را دنبال کن.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
@forelse($tournaments as $tournament) @include('site.partials.tournament-card', ['tournament' => $tournament]) @empty
<div class="col-12"><div class="gc-empty">جامی برای نمایش وجود ندارد.</div></div>
@endforelse
</div>{{ $tournaments->links() }}</div></section>
@endsection
