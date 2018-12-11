@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
@endphp

<a href="{{ filter('unread') }}" class="">
    {{ __('Unread') }}
</a>

<nav class="flex flex-wrap justify-center mt-4 mb-4 m-4">
    @foreach($posts as $post)
        <post-card :post="$post" :user="$user"></post-card>
    @endforeach
    
    @if($posts->isEmpty())
        {{ __('Nothing to see here!') }}
    @endif
</nav>

{{ $posts->render() }}
