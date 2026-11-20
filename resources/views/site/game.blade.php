@extends('site.layouts.gamecenter')
@section('title', $game->title)
@section('hero') @include('site.partials.breadcrumb', ['title' => $game->title, 'subtitle' => $game->summary]) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
    <div class="col-lg-8"><div class="gc-panel">
        <img class="img-fluid rounded mb-4" src="{{ $game->image ? asset($game->image) : asset('site/gamecenter/assets/img/products/product01.jpg') }}" alt="{{ $game->title }}">
        @if($game->description)<div class="gc-copy">{!! nl2br(e($game->description)) !!}</div>@endif
    </div></div>
    <div class="col-lg-4"><div class="gc-panel"><h3>اطلاعات بازی</h3><p>سبک: {{ $game->genre ?: '—' }}</p><p>پلتفرم: {{ $game->platform ?: '—' }}</p><p>سازنده: {{ $game->developer ?: '—' }}</p><a class="gc-button" href="{{ route('site.tournaments') }}">دیدن جام‌ها</a></div></div>
</div>
@if($game->tournaments->isNotEmpty())<h2 class="mt-5 mb-3">جام‌های این بازی</h2><div class="row">@foreach($game->tournaments as $tournament) @include('site.partials.tournament-card', ['tournament' => $tournament]) @endforeach</div>@endif
</div></section>
@endsection
