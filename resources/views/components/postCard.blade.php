@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
@endphp

<div
   class="
        bg-white shadow-lg block p-4 w-full
        border border-l-2 hover:border-black border-gray-light
        flex
        text-grey-dark
    "
>
    <div
        class="
            mr-4 w-32
            @if($user && $user->votedFor($post))
                voted-for
            @endif
        "
         id="post-vote-{{$post->uuid}}"
    >
        <span class="vote-count">{{ $post->vote_count }}</span> votes

        @if ($user)
            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
                data-done="updateVote"
                class="delete-vote-button"
            >
                {{ __('Remove vote') }}
            </ajax-button>

            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
                data-done="updateVote"
                class="add-vote-button"
            >
                {{ __('Add vote') }}
            </ajax-button>
        @endif
    </div>

    <div>
        <a
            class="post-link"
            href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
            rel="noopener noreferrer"
        >
            {{ $post->title }}
        </a>

        <br>
        <small>{{ $post->source->website }}</small>&thinsp;—&thinsp;<small>{{ $post->date_created->format('Y-m-d') }}</small>

        @if($post->tags->isNotEmpty())
            <div class="mt-2">
                @foreach ($post->tags as $tag)
                    <tag :tag="$tag"></tag>
                @endforeach
            </div>
        @endif
    </div>

    <div class="ml-auto">
        <small>
            {{ $post->view_count }} views
        </small>
    </div>
</div>
