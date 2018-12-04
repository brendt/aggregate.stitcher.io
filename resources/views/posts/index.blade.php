@php
/** @var \Domain\Post\Models\Post[] $posts */
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
                {{ $post->view_count }} views
            </li>

            <hr>
        @endforeach
    </ul>

    {{ $posts->render() }}
@endcomponent
