@extends('admin.layouts.gamecenter')
@section('title', 'بلاگ')
@section('content')
<div class="gc-section-title"><h1>مقاله‌های بلاگ</h1><a class="gc-button" href="{{ route('admin.gamecenter.posts.create') }}">مقاله تازه</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>عنوان</th><th>نویسنده</th><th>وضعیت</th><th>انتشار</th><th></th></tr></thead><tbody>@forelse($posts as $post)<tr><td>{{ $post->title }}</td><td>{{ $post->author?->name }}</td><td>{{ $post->status }}</td><td>{{ $post->published_at?->format('Y/m/d') ?? '—' }}</td><td><a href="{{ route('admin.gamecenter.posts.edit',$post) }}">ویرایش</a></td></tr>@empty<tr><td colspan="5">مقاله‌ای وجود ندارد.</td></tr>@endforelse</tbody></table>{{ $posts->links() }}</div>
@endsection
