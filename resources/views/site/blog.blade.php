@extends('site.layouts.gamecenter')
@section('title', 'بلاگ')
@section('hero') @include('site.partials.breadcrumb', ['title' => 'بلاگ گیم‌سنتر', 'subtitle' => 'خبرها، رویدادها و داستان‌های بازیکن‌ها.']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
@forelse($posts as $post) @include('site.partials.blog-card', ['post' => $post]) @empty
<div class="col-12"><div class="gc-empty">هنوز مقاله‌ای منتشر نشده است.</div></div>
@endforelse
</div>{{ $posts->links() }}</div></section>
@endsection
