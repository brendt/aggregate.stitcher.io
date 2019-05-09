 @if ($user)
    <ajax-button
        :action="action([\App\Http\Controllers\VotesController::class, 'delete'], $post)"
        data-done="updateVote"
        class="delete-vote-button mt-1/2"
        form-class="inline"
        title="Remove your upvote"
    >
        <upvote-icon/>

        <span class="vote-count ml-1 text-sm" data-vote-count="{{ $post->vote_count }}">{{ $post->vote_count }}</span>
    </ajax-button>

    <ajax-button
        :action="action([\App\Http\Controllers\VotesController::class, 'store'], $post)"
        data-done="updateVote"
        class="add-vote-button mt-1/2"
        form-class="inline"
        title="Show your support, give an upvote"
    >
        <upvote-icon/>

        <span class="vote-count mr-1 text-sm" data-vote-count="{{ $post->vote_count }}">{{ $post->vote_count }}</span>
    </ajax-button>
@else
    <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
        <upvote-icon></upvote-icon>
        <span class="vote-count ml-1 text-sm text-grey-dark">{{ $post->vote_count ?: 'vote' }}</span>
    </a>
@endif
