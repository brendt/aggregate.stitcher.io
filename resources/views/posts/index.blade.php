@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User|null $user */
    /** @var \Domain\Post\Models\Tag|null $tag */
    /** @var \Domain\Post\Models\Topic|null $topic */
@endphp

@component('layouts.feed', [
    'title' => $title,
])
    @if($tag)
        <h2 class="mt-8 text-4xl tag" style="--tag-color: {{ $tag->color }}; --badge-size: 10px">
            {{ $tag->getName() }}
        </h2>
    @endif

    <post-list
        :posts="$posts"
        :user="$user"
        :donationIndex="$donationIndex"
    ></post-list>
@endcomponent
