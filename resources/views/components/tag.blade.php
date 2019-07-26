@php
    /** @var \Domain\Post\Models\Tag $tag */
@endphp

<a
    href="{{ action([\App\Http\Controllers\PostsController::class, 'tag'], $tag->slug) }}"
    class="tag {{ $class ?? null }} {{ filter_active('tag', $tag) ? 'active' : null }}"
    style="--tag-color: {{ $tag->color }}"
>
    {{ $tag->name }}
</a>
