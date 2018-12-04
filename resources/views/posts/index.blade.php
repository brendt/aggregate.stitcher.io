@php
/** @var \Domain\Post\Models\Post[] $posts */
/** @var \Domain\User\Models\User $user */
@endphp

@component('layouts.app', [
    'title' => __('Posts'),
])
    <ul>
        @foreach($posts as $post)
            <li>
                {{ $post->date_created->format('Y-m-d') }}

                <a
                    href="{{ action([\App\Http\Controllers\PostsController::class, 'show'], $post) }}"
                    {{--target="_blank"--}}
                    rel="noopener noreferrer">
                    {{ $post->title }}
                </a>

                ({{ $post->source->website }})
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
            </li>

            <hr>
        @endforeach
    </ul>

    {{ $posts->render() }}
@endcomponent
