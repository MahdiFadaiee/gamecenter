@extends('admin.layouts.gamecenter')
@section('title', 'جوایز')
@section('content')
<h1>قوانین جایزه زمان بازی</h1>
<div class="gc-panel mb-4"><h3>قانون تازه</h3><form class="gc-form" method="POST" action="{{ route('admin.gamecenter.rewards.store') }}">@csrf
<label>نام جایزه</label><input name="name" required placeholder="مثلاً پاداش ۱۰۰ ساعت">
<div class="row"><div class="col-md-6"><label>هر چند ساعت بازی؟</label><input type="number" min="1" step="0.25" name="threshold_hours" value="100" required></div><div class="col-md-6"><label>چند ساعت رایگان؟</label><input type="number" min="0.25" step="0.25" name="reward_hours" value="10" required></div></div>
<label class="gc-check"><input type="checkbox" name="active" value="1" checked> فعال</label><button class="gc-button">افزودن قانون</button></form></div>
<div class="row">@forelse($rules as $rule)<div class="col-lg-6 mb-3"><form class="gc-panel gc-form" method="POST" action="{{ route('admin.gamecenter.rewards.update',$rule) }}">@csrf @method('PATCH')
<h3>{{ $rule->name }}</h3><label>نام جایزه</label><input name="name" value="{{ $rule->name }}" required>
<div class="row"><div class="col-6"><label>آستانه (ساعت)</label><input type="number" step="0.25" min="1" name="threshold_hours" value="{{ $rule->threshold_minutes/60 }}" required></div><div class="col-6"><label>پاداش (ساعت)</label><input type="number" step="0.25" min="0.25" name="reward_hours" value="{{ $rule->reward_minutes/60 }}" required></div></div>
<label class="gc-check"><input type="checkbox" name="active" value="1" @checked($rule->active)> فعال</label><button class="gc-button gc-button--small">ذخیره قانون</button>
</form></div>@empty<p>قانون جایزه‌ای تعریف نشده.</p>@endforelse</div>
<div class="gc-panel"><h2>جوایز صادرشده</h2><div class="table-responsive"><table class="gc-table"><thead><tr><th>عضو</th><th>قانون</th><th>جایزه</th><th>مرحله</th><th>وضعیت</th><th>تاریخ</th></tr></thead><tbody>@forelse($awards as $award)<tr><td>{{ $award->user->name }}</td><td>{{ $award->rule->name }}</td><td>{{ intdiv($award->reward_minutes,60) }} ساعت</td><td>{{ $award->milestone }}</td><td>{{ $award->status==='available' ? 'قابل استفاده' : 'استفاده‌شده' }}</td><td>{{ $award->issued_at->format('Y/m/d') }}</td></tr>@empty<tr><td colspan="6">جایزه‌ای صادر نشده.</td></tr>@endforelse</tbody></table>{{ $awards->links() }}</div></div>
@endsection
