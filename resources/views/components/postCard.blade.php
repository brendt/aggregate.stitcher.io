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
    <div class="mr-4 w-32">
        <span id="vote-count-{{ $post->uuid }}">{{ $post->vote_count }}</span> votes

        @if ($user)
            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
                :data-done="'updateVote'"
                :class="$user->votedFor($post) ? '' : 'hidden'"
                :id="'delete-vote-' . $post->uuid"
            >
                {{ __('Remove vote') }}
            </ajax-button>

            <ajax-button
                :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
                :data-done="'updateVote'"
                :class="$user->votedFor($post) ? 'hidden' : ''"
                :id="'add-vote-' . $post->uuid"
            >
                {{ __('Add vote') }}
            </ajax-button>
        @endif
    </div>

    <div>
        <a
            class="hover:text-black"
            href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
            rel="noopener noreferrer"
        >
            {{ $post->title }}
            <br>
            <small>{{ $post->source->website }}</small>&thinsp;—&thinsp;<small>{{ $post->date_created->format('Y-m-d') }}</small>
        </a>
        <br>
        <div class="mt-2">
            @foreach ($post->tags as $tag)
                <tag :tag="$tag"></tag>
            @endforeach
        </div>
    </div>

    <div class="ml-auto">
        <small>
            {{ $post->view_count }} views
        </small>
    </div>
</div>
