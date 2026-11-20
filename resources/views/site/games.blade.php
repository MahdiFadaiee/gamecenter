@extends('site.layouts.gamecenter')
@section('title', 'بازی‌ها')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'بازی‌های گیم‌سنتر', 'subtitle' => 'بازی مورد علاقه‌ات را انتخاب کن و آماده رقابت شو.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
@forelse($games as $game) @include('site.partials.game-card', ['game' => $game]) @empty
<div class="col-12"><div class="gc-empty">هنوز بازی‌ای برای نمایش ثبت نشده است.</div></div>
@endforelse
</div>{{ $games->links() }}</div></section>
@endsection
