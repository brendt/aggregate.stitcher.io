@component('layouts.app', [
    'title' => $title ?? null,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex">
        <x-active-link
            :href="action([\App\User\Controllers\UserProfileController::class, 'index'])"
        >{{ __('Profile') }}</x-active-link>

        <x-active-link
            :href="action([\App\User\Controllers\UserSourcesController::class, 'index'])"
            class="ml-4"
        >{{ __('My blog') }}</x-active-link>

        <x-active-link
            :href="action([\App\User\Controllers\UserInterestsController::class, 'index'])"
            class="ml-4"
        >{{ __('Interests') }}</x-active-link>

        <x-active-link
            :href="action([\App\User\Controllers\UserMutesController::class, 'index'])"
            class="ml-4"
        >{{ __('Mutes') }}</x-active-link>
    </nav>

    {{ $slot }}
@endcomponent
