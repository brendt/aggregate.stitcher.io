@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
    $last = $last ?? true;
@endphp

<div class="w-full flex py-6">
    <div
        class="mr-6 {{ $user && $user->votedFor($post) ? 'voted-for' : null }}"
        id="post-vote-{{ $post->uuid }}"
    >
        {{-- @if ($user) --}}
            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
                data-done="updateVote"
                class="delete-vote-button"
                style="margin-top: 0.175rem"
            >
                <heart-icon />
            </ajax-button>

            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
                data-done="updateVote"
                class="add-vote-button"
                style="margin-top: 0.175rem"
            >
                <heart-icon :fill="rand(0, 1) ? 'red' : null" />
            </ajax-button>
        {{-- @endif --}}
    </div>

    <div class="flex-1">
        <p class="mb-1">
            <a
                class="text-xl font-bold font-title {{ $user && $user->hasViewed($post) ? 'viewed' : '' }}"
                href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
                rel="noopener noreferrer"
            >
                {{ $post->title }}
            </a>
        </p>

        <p class="text-grey-dark text-sm">
            {{ $post->vote_count }} {{ str_plural('vote', $post->vote_count) }}
            –
            <a href="https://{{ $post->source->website }}" class="underline">{{ $post->source->website }}</a>
            –
            <a href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}" class="underline">
                {{ $post->relative_date }}
            </a>
        </p>
        @if($post->tags->isNotEmpty())
            <p class="text-sm mt-2">
                @foreach ($post->tags as $tag)
                    <tag :tag="$tag" class="mr-1/2"></tag>
                @endforeach
            </p>
        @endif
    </div>
</div>
