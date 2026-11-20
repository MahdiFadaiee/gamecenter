@extends('admin.layouts.gamecenter')
@section('title', 'صفحه‌های سایت')
@section('content')
<div class="gc-section-title"><h1>صفحه‌های سایت</h1><a class="gc-button" href="{{ route('admin.gamecenter.pages.create') }}">صفحه تازه</a></div>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>عنوان</th><th>پیوند</th><th>وضعیت</th><th></th></tr></thead><tbody>@forelse($pages as $page)<tr><td>{{ $page->title }}</td><td><a href="{{ route('site.page',$page->slug) }}">/pages/{{ $page->slug }}</a></td><td>{{ $page->status }}</td><td><a href="{{ route('admin.gamecenter.pages.edit',$page) }}">ویرایش</a></td></tr>@empty<tr><td colspan="4">صفحه‌ای ساخته نشده.</td></tr>@endforelse</tbody></table>{{ $pages->links() }}</div>
@endsection
