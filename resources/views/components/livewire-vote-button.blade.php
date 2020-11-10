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
         <x-upvote-icon/>

         @if ($voteCount)
            <span class="vote-count ml-1 text-sm text-grey-darkest font-bold">{{ $voteCount }}</span>
         @else
            <span class="vote-count ml-1 text-sm text-red font-bold">vote</span>
         @endif
     </button>
@else
    <a href="{{ action([\App\User\Controllers\RegisterController::class, 'showRegistrationForm']) }}">
        <x-upvote-icon></x-upvote-icon>
        <span class="vote-count ml-1 text-sm text-red font-bold">vote</span>
    </a>
@endif
