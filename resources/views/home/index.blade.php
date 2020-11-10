@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User|null $user */
    /** @var \Domain\Post\Models\Tag|null $currentTag */
    /** @var \Domain\Post\Models\Topic|null $currentTopic */
@endphp

@component('layouts.app', [
    'title' => $title,
    'header' => ''
])
    <div class="text-black pt-1 mb-2">
        <h1 class="font-serif text-primary text-4xl font-bold">Aggregate: community driven content</h1>

        <div class="content">
            <p>
                Aggregate will search the web for quality content so you don't have to.
                We're scanning a curated list of quality content, and send you to it.
            </p>

            <p class="mt-4">
                Are you a content creator? <a class="link" href="{{ action([\App\User\Controllers\GuestSourcesController::class, 'index']) }}">
                    Submit your feed</a>.
            </p>
        </div>
    </div>

    <x-post-list
        :posts="$posts"
        :user="$user"
        :donation-index="$donationIndex"
        :show-pagination="false"
        :show-donation="false"
    ></x-post-list>

    <div class="flex justify-center mt-8">
        <a href="{{ action([\App\User\Controllers\RegisterController::class, 'register']) }}" class="
            p-3 px-4
            leading-normal
            bg-primary text-white
            border-primary border-2
            hover:bg-white hover:text-primary
        ">
            Discover more
        </a>
    </div>
@endcomponent
