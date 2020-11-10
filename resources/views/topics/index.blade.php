@php
/** @var \Domain\Post\Models\Topic[] $topics */
@endphp

@component('layouts.app', [
    'title' => __('Topics'),
])
    <x-heading>
        {{ __('Topics') }}
    </x-heading>

    <nav class="mt-4">
        @foreach($topics as $topic)
            <a href="{{ action([\App\Feed\Controllers\PostsController::class, 'topic'], $topic->slug) }}">
                <h2>
                    {{ $topic->name }}
                </h2>
            </a>
        @endforeach
    </nav>
@endcomponent
