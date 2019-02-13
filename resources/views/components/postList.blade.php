@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */
@endphp

<section>
    @foreach($posts as $post)
        @if ($loop->index === $donationIndex)
            <donation-card></donation-card>
        @endif

        <post-card
            :post="$post"
            :user="$user"
            :last="$loop->last"
        ></post-card>
    @endforeach
</section>

{{ $posts->render() }}
