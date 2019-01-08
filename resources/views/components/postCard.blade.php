@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
    $last = $last ?? true;
@endphp

<div class="w-full flex py-6" id="post-vote-{{ $post->uuid }}">
    <div
        class="mr-6 {{ $user && $user->votedFor($post) ? 'voted-for' : null }}"
    >
         {{--@if ($user) --}}
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
                <heart-icon />
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
            <span class="vote-count">{{ $post->vote_count }}</span> {{ str_plural('vote', $post->vote_count) }}
            –
            <a href="https://{{ $post->source->website }}" class="underline">{{ $post->source->website }}</a>
            –
            <a href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}" class="underline">
                {{ $post->relative_date }}
            </a>
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
</div>
