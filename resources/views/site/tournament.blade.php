@extends('site.layouts.gamecenter')
@section('title', $tournament->name)
@section('hero') @include('site.partials.breadcrumb', ['title' => $tournament->name, 'subtitle' => $tournament->game?->title ?? 'جام گیم‌سنتر']) @endsection
@section('content')
<section class="gc-section"><div class="container"><div class="row">
    <div class="col-lg-8"><div class="gc-panel">
        @if($tournament->cover_image)<img class="img-fluid rounded mb-4" src="{{ asset($tournament->cover_image) }}" alt="{{ $tournament->name }}">@endif
        @if($tournament->description)<div>{!! nl2br(e($tournament->description)) !!}</div>@endif
        <p class="mt-3">زمان شروع: {{ $tournament->starts_at?->format('Y/m/d H:i') ?? 'به‌زودی اعلام می‌شود' }}</p>
        @if($tournament->prize)<p>جایزه: {{ $tournament->prize }}</p>@endif
        @auth
            @if($tournament->status === 'open')
                <form method="POST" action="{{ route('member.tournaments.register', $tournament) }}">@csrf<button class="gc-button">ثبت‌نام در جام</button></form>
            @endif
        @else
            <a class="gc-button" href="{{ route('login') }}">برای ثبت‌نام وارد شو</a>
        @endauth
    </div>
    @if($tournament->matches->isNotEmpty())<div class="gc-panel mt-4"><h3>برنامه و نتیجه‌ها</h3><div class="table-responsive"><table class="gc-table"><thead><tr><th>مرحله</th><th>بازیکن‌ها</th><th>نتیجه</th><th>زمان</th></tr></thead><tbody>@foreach($tournament->matches as $match)<tr><td>{{ $match->round ?: '—' }}</td><td>{{ $match->playerOne?->name ?? '—' }} / {{ $match->playerTwo?->name ?? '—' }}</td><td>{{ $match->score_one ?? '—' }} : {{ $match->score_two ?? '—' }}</td><td>{{ $match->scheduled_at?->format('Y/m/d H:i') ?? '—' }}</td></tr>@endforeach</tbody></table></div></div>@endif
    </div>
    <div class="col-lg-4"><div class="gc-panel"><h3>شرکت‌کننده‌ها</h3><p>{{ $tournament->registrations->count() }} بازیکن @if($tournament->max_participants) از {{ $tournament->max_participants }} @endif</p><ul class="list-wrap">@forelse($tournament->registrations as $registration)<li><a href="{{ route('site.player', $registration->user->username) }}">{{ $registration->user->name }}</a></li>@empty<li>هنوز کسی ثبت‌نام نکرده.</li>@endforelse</ul></div></div>
</div></div></section>
@endsection
