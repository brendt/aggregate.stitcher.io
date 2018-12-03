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
                <a href="{{ $post->url }}" target="_blank" rel="noopener noreferrer">{{ $post->title }}</a>
                ({{ $post->source->website }})
            </li>
        @endforeach
    </ul>
@endcomponent
