<div class="col-lg-4 col-md-6 mb-4">
    <article class="gc-card h-100">
        <a href="{{ route('site.game', $game->slug) }}" class="gc-card__image">
            <img src="{{ $game->image ? asset($game->image) : asset('site/gamecenter/assets/img/products/product01.jpg') }}" alt="{{ $game->title }}">
        </a>
        <div class="gc-card__body">
            @if($game->genre)<span class="gc-tag">{{ $game->genre }}</span>@endif
            <h3><a href="{{ route('site.game', $game->slug) }}">{{ $game->title }}</a></h3>
            <p>{{ $game->summary }}</p>
            <a class="gc-link" href="{{ route('site.game', $game->slug) }}">جزئیات بازی ←</a>
        </div>
    </article>
</div>
