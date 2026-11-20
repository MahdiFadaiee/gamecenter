@extends('site.layouts.gamecenter')
@section('title', $page->title)
@section('hero') @include('site.partials.breadcrumb', ['title' => $page->title]) @endsection
@section('content')
<section class="gc-section"><div class="container"><article class="gc-panel mx-auto" style="max-width:900px"><div class="gc-copy">{!! nl2br(e($page->body)) !!}</div></article></div></section>
@endsection
