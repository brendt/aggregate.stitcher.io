 @if ($user)
     <button
         type="button"
         class="
            ajax-button
            mt-1/2
            {{ $hasVoted ? 'voted-for' : '' }}
         "
         wire:click="toggleVote"
     >
         <upvote-icon/>

         <span class="vote-count ml-1 text-sm text-grey-darkest">{{ $post->vote_count ?: 'vote' }}</span>
     </button>
@else
    <a href="{{ action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']) }}">
        <upvote-icon></upvote-icon>
        <span class="vote-count ml-1 text-sm text-grey-darkest">{{ $post->vote_count ?: 'vote' }}</span>
    </a>
@endif
