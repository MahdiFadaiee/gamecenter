<div class="col-lg-4 col-md-6 mb-4">
    <article class="gc-card h-100">
        <a href="{{ route('site.post', $post->slug) }}" class="gc-card__image">
            <img src="{{ $post->cover_image ? asset($post->cover_image) : asset('site/gamecenter/assets/img/blog/blog_post01.jpg') }}" alt="{{ $post->title }}">
        </a>
        <div class="gc-card__body">
            <span class="gc-meta">{{ $post->published_at?->format('Y/m/d') ?? $post->created_at?->format('Y/m/d') }}</span>
            <h3><a href="{{ route('site.post', $post->slug) }}">{{ $post->title }}</a></h3>
            <p>{{ $post->excerpt }}</p>
            <a class="gc-link" href="{{ route('site.post', $post->slug) }}">ادامه مطلب ←</a>
        </div>
    </article>
</div>
