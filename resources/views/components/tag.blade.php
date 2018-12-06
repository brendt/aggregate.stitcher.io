@php
    /** @var \Domain\Post\Models\Tag $tag */
@endphp

<a
    href="{{ filter('tags.name', $tag) }}"
    class="
        tag
        inline-block
        p-2 pt-1 pb-1
        border
        text-xs
        @if(is_filter_active('tags.name', $tag))
            active
        @endif
    "
    style="--tag-color: {{ $tag->color }}"
>
    {{ $tag->name }}
</a>
