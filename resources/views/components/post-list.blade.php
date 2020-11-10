@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User $user */

    $showDonation = $showDonation ?? true;
    $showPagination = $showPagination ?? true;
@endphp

<section>
    @foreach($posts as $post)
        <x-post-card
            :post="$post"
            :user="$user"
            :last="$loop->last"
        ></x-post-card>
    @endforeach
</section>

@if($showPagination)
    {{ $posts->render() }}
@endif
