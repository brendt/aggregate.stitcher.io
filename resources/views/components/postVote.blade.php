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
