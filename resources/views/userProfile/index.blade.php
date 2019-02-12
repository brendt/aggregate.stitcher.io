@component('layouts.app', [
    'title' => __('My profile')
])

    <heading>{{ __('Edit my Profile') }}</heading>


    <form-component :action="action([\App\Http\Controllers\UserProfileController::class, 'update'])">

        <text-field
            name="password"
            type="password"
            :label="__('password')"
        ></text-field>

        <text-field
            name="password_confirmation"
            type="password"
            :label="__('Confirm  password')"
        ></text-field>

        <submit-button class="mt-3">
            {{ __('Save') }}
        </submit-button>

    </form-component>

@endcomponent
