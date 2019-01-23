@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
@endphp

<article
    id="post-vote-{{ $post->uuid }}"
    class="w-full flex items-center py-8 border-b border-grey-lighter"
>
    <div class="flex-1">
        <p class="mb-2">
            <a
                class="text-xl font-bold font-title post-link {{ $user && $user->hasViewed($post) ? 'viewed' : '' }}"
                href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
                rel="noopener noreferrer"
            >
                {{ $post->title }}
            </a>
        </p>

        <p class="text-grey-dark text-sm">
            <a href="{{ action([\App\Http\Controllers\PostsController::class, 'source'], $post->source->website) }}" class="link">{{ $post->source->website }}</a>
            –
            {{ $post->relative_date }}
        </p>

        <div class="flex items-baseline mt-2">
            @if($post->tags->isNotEmpty())
                <p class="text-sm mr-2">
                    @foreach ($post->tags as $tag)
                        <tag :tag="$tag" class="mr-1/2"></tag>
                    @endforeach
                </p>
            @endif

            @if ($user)
                @if(! $user->hasMuted($post->source))
                    <post-button
                        :action="$post->source->getMuteUrl()"
                    >
                        <span class="
                            underline
                            text-grey text-sm
                            hover:no-underline
                        ">
                            {{ __('Mute source') }}
                        </span>
                    </post-button>
                @endif
            @endif
        </div>
    </div>
    <div class="{{ $user && $user->votedFor($post) ? 'voted-for' : null }}">
        @if ($user)
            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
                data-done="updateVote"
                class="delete-vote-button mt-1/2"
            >
                <span class="vote-count">{{ $post->vote_count }}</span>
                <heart-icon/>
            </ajax-button>

            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
                data-done="updateVote"
                class="add-vote-button mt-1/2"
            >
                <span class="vote-count">{{ $post->vote_count }}</span>
                <heart-icon/>
            </ajax-button>
        @else
            <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
                <span class="vote-count">{{ $post->vote_count ?: null }}</span>
                <heart-icon></heart-icon>
            </a>
        @endif
    </div>
</article>
