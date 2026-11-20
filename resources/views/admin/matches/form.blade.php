@extends('admin.layouts.gamecenter')
@section('title', $match->exists ? 'ویرایش مسابقه' : 'ثبت مسابقه')
@section('content')
<h1>{{ $match->exists ? 'ویرایش برنامه و نتیجه' : 'زمان‌بندی مسابقه' }}</h1>
<form class="gc-panel gc-form" method="POST" action="{{ $match->exists ? route('admin.gamecenter.matches.update',$match) : route('admin.gamecenter.matches.store') }}">@csrf @if($match->exists) @method('PATCH') @endif
<label>جام</label><select name="tournament_id" required>@foreach($tournaments as $tournament)<option value="{{ $tournament->id }}" @selected(old('tournament_id',$match->tournament_id)==$tournament->id)>{{ $tournament->name }}</option>@endforeach</select>
<label>مرحله</label><input name="round" value="{{ old('round',$match->round) }}" placeholder="مثلاً نیمه‌نهایی">
<label>بازیکن اول</label><select name="player_one_id"><option value="">تعیین نشده</option>@foreach($members as $member)<option value="{{ $member->id }}" @selected(old('player_one_id',$match->player_one_id)==$member->id)>{{ $member->name }}</option>@endforeach</select>
<label>بازیکن دوم</label><select name="player_two_id"><option value="">تعیین نشده</option>@foreach($members as $member)<option value="{{ $member->id }}" @selected(old('player_two_id',$match->player_two_id)==$member->id)>{{ $member->name }}</option>@endforeach</select>
<label>زمان برگزاری</label><input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at',$match->scheduled_at?->format('Y-m-d\\TH:i')) }}">
<div class="row"><div class="col-md-6"><label>امتیاز بازیکن اول</label><input type="number" min="0" name="score_one" value="{{ old('score_one',$match->score_one) }}"></div><div class="col-md-6"><label>امتیاز بازیکن دوم</label><input type="number" min="0" name="score_two" value="{{ old('score_two',$match->score_two) }}"></div></div>
<label>وضعیت</label><select name="status">@foreach(['scheduled'=>'برنامه‌ریزی‌شده','completed'=>'پایان‌یافته','cancelled'=>'لغوشده'] as $value=>$label)<option value="{{ $value }}" @selected(old('status',$match->status ?: 'scheduled')===$value)>{{ $label }}</option>@endforeach</select>
<button class="gc-button">ذخیره مسابقه</button></form>
@endsection
