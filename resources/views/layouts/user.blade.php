@component('layouts.app', [
    'title' => $title ?? null,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex">
        <active-link
            :href="action([\App\Http\Controllers\UserProfileController::class, 'index'])"
        >{{ __('Profile') }}</active-link>

        <active-link
            :href="action([\App\Http\Controllers\UserSourcesController::class, 'index'])"
            class="ml-4"
        >{{ __('My feed') }}</active-link>

        <active-link
            :href="action([\App\Http\Controllers\UserMutesController::class, 'index'])"
            class="ml-4"
        >{{ __('Mutes') }}</active-link>
    </nav>

    {{ $slot }}
@endcomponent
