@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
@endphp

@if($user)
    <a href="{{ filter('unread') }}"
       class="
            tag
            inline-block
            p-2 pt-1 pb-1
            border
            @if(is_filter_active('unread'))
                active
            @endif
       "
       style="--tag-color: #000"
    >
        {{ __('Unread') }}
    </a>
@endif

<nav class="flex flex-wrap justify-center mt-4 mb-4 m-4">
    @foreach($posts as $post)
        <post-card :post="$post" :user="$user"></post-card>
    @endforeach

    @if($posts->isEmpty())
        {{ __('Nothing to see here!') }}
    @endif
</nav>

{{ $posts->render() }}
