@php
    /** @var \Domain\Language\Language[] $languages */
    /** @var \Domain\User\Models\User $user */
@endphp

@component('layouts.user', [
    'title' => __('My profile')
])
    <heading>{{ __('Languages') }}</heading>

    <p class="mt-2">
        Specify which languages you want showing up in your feed.
    </p>

    <div class="mt-4">
        @foreach($languages as $language)
            <div class="mt-2">
                {{ $language->name }}
                <a
                    href="{{ action([\App\Http\Controllers\UserProfileController::class, 'removeLanguage'], ['language' => $language->code]) }}"
                    class="text-red-dark font-bold"
                >
                    X
                </a>
            </div>
        @endforeach
    </div>

    <form-component :action="action([\App\Http\Controllers\UserProfileController::class, 'addLanguage'])" class="mt-4">
        <select-field
            name="language"
            :label="__('New language')"
            :options="$languageOptions"
        ></select-field>

        <submit-button class="mt-3">
            {{ __('Add language') }}
        </submit-button>
    </form-component>

    <heading>{{ __('New password') }}</heading>

    <form-component :action="action([\App\Http\Controllers\UserProfileController::class, 'updatePassword'])" class="mt-4">
        <text-field
            name="password"
            type="password"
            :label="__('New password')"
        ></text-field>

        <text-field
            name="password_confirmation"
            type="password"
            :label="__('Confirm new password')"
        ></text-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>
    </form-component>

@endcomponent
