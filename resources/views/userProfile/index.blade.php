@php
    /** @var \Domain\Language\Language[] $languages */
    /** @var \Domain\User\Models\User $user */
@endphp

@component('layouts.user', [
    'title' => __('My profile')
])
    <x-heading>{{ __('Languages') }}</x-heading>

    <p class="mt-2">
        Specify which languages you want showing up in your feed.
    </p>

    <div class="mt-4">
        @foreach($languages as $language)
            <div class="mt-2">
                {{ $language->name }}
                <a
                    href="{{ action([\App\User\Controllers\UserProfileController::class, 'removeLanguage'], ['language' => $language->code]) }}"
                    class="text-red-dark font-bold"
                >
                    X
                </a>
            </div>
        @endforeach
    </div>

    <x-form-component :action="action([\App\User\Controllers\UserProfileController::class, 'addLanguage'])"
                      class="mt-4">
        <x-select-field
                name="language"
                :label="__('New language')"
                :options="$languageOptions"
        ></x-select-field>

        <x-submit-button class="mt-3">
            {{ __('Add language') }}
        </x-submit-button>
    </x-form-component>

    <x-heading>{{ __('New password') }}</x-heading>

    <x-form-component :action="action([\App\User\Controllers\UserProfileController::class, 'updatePassword'])"
                      class="mt-4">
        <x-text-field
                name="password"
                type="password"
                :label="__('New password')"
        ></x-text-field>

        <x-text-field
                name="password_confirmation"
                type="password"
                :label="__('Confirm new password')"
        ></x-text-field>

        <x-submit-button class="mt-3">
            {{ __('Save') }}
        </x-submit-button>
    </x-form-component>

@endcomponent
