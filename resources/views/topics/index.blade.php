@php
/** @var \Domain\Post\Models\Topic[] $topics */
@endphp

@component('layouts.app', [
    'title' => __('Topics'),
])
    <heading>
        {{ __('Topics') }}
    </heading>

    <nav class="mt-4">
        @foreach($topics as $topic)
            <a href="{{ filter('topic', $topic)->withBaseUrl(action([\App\Http\Controllers\PostsController::class, 'index'])) }}">
                <h2>
                    {{ $topic->name }}
                </h2>
            </a>
        @endforeach
    </nav>
@endcomponent
