@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
@endphp

<nav class="flex flex-wrap justify-center mt-4 mb-4">
    @foreach($posts as $post)
        <post-card :post="$post" :user="$user"></post-card>
    @endforeach
</nav>

{{ $posts->render() }}
