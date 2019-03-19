<div>
    @if ($user)
        <ajax-button
            :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
            data-done="updateVote"
            class="delete-vote-button mt-1/2"
            title="Remove your upvote"
        >
            <span class="vote-count mr-1 text-sm">
                @if($post->vote_count)
                    {{ $post->vote_count }}
                @endif
            </span>
            <upvote-icon/>
        </ajax-button>

        <ajax-button
            :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
            data-done="updateVote"
            class="add-vote-button mt-1/2"
            title="Show your support, give an upvote"
        >
            <span class="vote-count mr-1 text-sm">
                @if($post->vote_count)
                    {{ $post->vote_count }}
                @endif
            </span>
            <upvote-icon/>
        </ajax-button>
    @else
        <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
            <span class="vote-count">{{ $post->vote_count ?: null }}</span>
            <upvote-icon></upvote-icon>
        </a>
    @endif
</div>
