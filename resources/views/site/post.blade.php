@extends('site.layouts.gamecenter')
@section('title', $post->title)
@section('hero') @include('site.partials.breadcrumb', ['title' => $post->title, 'subtitle' => $post->excerpt]) @endsection
@section('content')
<section class="gc-section"><div class="container"><article class="gc-panel mx-auto" style="max-width:900px">
    @if($post->cover_image)<img class="img-fluid rounded mb-4" src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}">@endif
    <div class="gc-meta mb-3">{{ $post->published_at?->format('Y/m/d') }} @if($post->author) · {{ $post->author->name }} @endif</div>
    <div class="gc-copy">{!! nl2br(e($post->body)) !!}</div>
</article></div></section>
@endsection
