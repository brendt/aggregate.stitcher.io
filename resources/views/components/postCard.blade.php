@php
    /** @var \Domain\Post\Models\Post $post */
    /** @var \Domain\User\Models\User $user */
@endphp

<a
   href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
   rel="noopener noreferrer"
   class="
        bg-white shadow-lg block p-4 w-full cursor-pointer
        border border-l-2 hover:border-black border-gray-light
        flex
        text-grey-dark hover:text-black
    "
>
    <div class="mr-4 w-32">
        {{ $post->vote_count }} votes

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
    </div>

    <div>
        {{ $post->title }}
        <br>
        <small>{{ $post->source->website }}</small>&thinsp;—&thinsp;<small>{{ $post->date_created->format('Y-m-d') }}</small>
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
</a>
