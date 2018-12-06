@php
    /** @var \Domain\Post\Models\Tag $tag */
@endphp

<small
    href="#"
    class="
        tag
        inline-block
        p-2 pt-1 pb-1
        border
    "
    style="--tag-color: {{ $tag->color }}"
>
    {{ $tag->name }}
</small>
