@php
    /** @var \Domain\Source\Models\Source[] $sources */
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
@endphp

<div>
    @if($user)
        <a href="{{ filter('unread') }}"
           class="
                tag
                inline-block
                p-2 pt-1 pb-1
                border
                {{ filter_active('unread') ? 'active' : '' }}
               "
           style="--tag-color: #000"
        >
            {{ __('Unread') }}
        </a>
    @endif

    @foreach($sources as $source)
        <a href="{{ filter('sources.website[]', $source) }}">
            {{ $source->website }}
        </a>
    @endforeach

    @if (filter_active('sources.website[]'))
        <a href="{{ clear_filter('sources.website[]') }}">
            {{ __('clear') }}
        </a>
    @endif
</div>

<nav class="flex flex-wrap justify-center mt-4 mb-4 m-4">
    @foreach($posts as $post)
        <post-card :post="$post" :user="$user"></post-card>
    @endforeach

    @if($posts->isEmpty())
        {{ __('Nothing to see here!') }}
    @endif
</nav>

{{ $posts->render() }}
