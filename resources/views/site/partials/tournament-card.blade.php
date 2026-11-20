<div class="col-lg-4 col-md-6 mb-4">
    <article class="gc-card h-100">
        <a href="{{ route('site.tournament', $tournament->slug) }}" class="gc-card__image">
            <img src="{{ $tournament->cover_image ? asset($tournament->cover_image) : asset('site/gamecenter/assets/img/products/product04.jpg') }}" alt="{{ $tournament->name }}">
        </a>
        <div class="gc-card__body">
            <span class="gc-tag">{{ $tournament->game?->title ?? 'جام آزاد' }}</span>
            <h3><a href="{{ route('site.tournament', $tournament->slug) }}">{{ $tournament->name }}</a></h3>
            <p>{{ $tournament->starts_at?->format('Y/m/d H:i') ?? 'زمان برگزاری به‌زودی اعلام می‌شود' }}</p>
            <a class="gc-link" href="{{ route('site.tournament', $tournament->slug) }}">اطلاعات و ثبت‌نام ←</a>
        </div>
    </article>
</div>
