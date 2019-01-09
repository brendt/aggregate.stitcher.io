@php
    /** @var \Domain\Post\Models\Tag $tag */
@endphp

<a
    href="{{ filter('tags.slug', $tag) }}"
    class="tag {{ $class ?? null }} {{ filter_active('tags.slug', $tag) ? 'active' : null }}"
    style="--tag-color: {{ $tag->color }}"
>
    <span class="tag-inner">
        {{ $tag->name }}
    </span>
</a>
