@php
    /** @var \Domain\Post\Models\Post[] $posts */
    /** @var \Domain\User\Models\User|null $user */
    /** @var \Domain\Post\Models\Tag|null $tag */
    /** @var \Domain\Post\Models\Topic|null $topic */
@endphp

@component('layouts.feed', [
    'title' => 'Complete your profile',
])
    <div class="content">
        <h1 class="font-title text-2xl mt-4 mb-8">
            {{ __('Complete your profile') }}
        </h1>

        <p>
            In order to view your feed, you must select some topics you're interested in reading about. You can always make changes to this list in the
            <a href="{{ action([\App\User\Controllers\UserInterestsController::class, 'index']) }}" target="_blank" rel="noopener noreferrer">profile section</a>.
        </p>
    </div>

    @include('userInterests.partials.form')
@endcomponent
