@php
    /** @var \Domain\Post\Models\Tag $tag */
@endphp

<a
    href="{{ filter('tag', $tag) }}"
    class="tag {{ $class ?? null }} {{ filter_active('tag', $tag) ? 'active' : null }}"
    style="--tag-color: {{ $tag->color }}"
>
    <span class="tag-inner">
        {{ $tag->name }}
    </span>
</a>
