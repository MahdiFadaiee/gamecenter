@extends('site.layouts.gamecenter')
@section('title', $title)
@section('hero') @include('site.partials.breadcrumb', ['title' => $title, 'subtitle' => $eyebrow]) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="gc-panel mx-auto" style="max-width:900px"><p>{{ $body }}</p></div></div></section>
@endsection
