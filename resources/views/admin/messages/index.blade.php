@extends('admin.layouts.gamecenter')
@section('title', 'پیام‌های سایت')
@section('content')
<h1>پیام‌های تماس</h1>
<div class="gc-panel table-responsive"><table class="gc-table"><thead><tr><th>فرستنده</th><th>موضوع</th><th>پیام</th><th>زمان</th><th>وضعیت</th><th></th></tr></thead><tbody>@forelse($messages as $message)<tr><td>{{ $message->name }}<br>{{ $message->email }}</td><td>{{ $message->subject }}</td><td>{{ Str::limit($message->message,120) }}</td><td>{{ $message->created_at->format('Y/m/d H:i') }}</td><td>{{ $message->status }}</td><td>@if($message->status==='unread')<form method="POST" action="{{ route('admin.gamecenter.messages.update',$message) }}">@csrf @method('PATCH')<button class="gc-button gc-button--small">خوانده شد</button></form>@endif</td></tr>@empty<tr><td colspan="6">پیامی دریافت نشده.</td></tr>@endforelse</tbody></table>{{ $messages->links() }}</div>
@endsection
