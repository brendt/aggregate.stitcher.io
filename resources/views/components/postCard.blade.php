@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
@endphp

<a
   href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
   rel="noopener noreferrer"
   class="
        bg-white shadow-lg block p-4 mb-4 mr-4 w-sm cursor-pointer
        border-2 hover:border-green-dark border-red-lighter visited-border-gray-light
    "
>
    {{ $post->date_created->format('Y-m-d') }}

    {{ $post->title }}

    <br>

    <small>{{ $post->source->website }}</small>

    <br><br>

    {{ $post->vote_count }} votes
    <br>

    @if ($user)
        @if ($user->votedFor($post))
            <form
                action="{{ action([\App\Http\Controllers\VotesController::class, 'delete'], $post) }}"
                method="post"
            >
                @csrf

                <button type="submit">
                    {{ __('Remove vote') }}
                </button>
            </form>
        @else
            <form
                action="{{ action([\App\Http\Controllers\VotesController::class, 'store'], $post) }}"
                method="post"
            >
                @csrf

                <button type="submit">
                    {{ __('Add vote') }}
                </button>
            </form>
        @endif
    @endif

    <br>
    {{ $post->view_count }} views
</a>
