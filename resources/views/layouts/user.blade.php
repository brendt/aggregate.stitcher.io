@component('layouts.app', [
    'title' => $title ?? null,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex">
        <active-link
            :href="action([\App\User\Controllers\UserProfileController::class, 'index'])"
        >{{ __('Profile') }}</active-link>

        <active-link
            :href="action([\App\User\Controllers\UserSourcesController::class, 'index'])"
            class="ml-4"
        >{{ __('My blog') }}</active-link>

        <active-link
            :href="action([\App\User\Controllers\UserInterestsController::class, 'index'])"
            class="ml-4"
        >{{ __('Interests') }}</active-link>

        <active-link
            :href="action([\App\User\Controllers\UserMutesController::class, 'index'])"
            class="ml-4"
        >{{ __('Mutes') }}</active-link>
    </nav>

    {{ $slot }}
@endcomponent
