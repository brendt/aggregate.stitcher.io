@component('layouts.app', [
    'title' => __('Password reset'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Choose a new password') }}
    </h1>

    <form-component :action="route('password.update')">
        <x-email-field
                name="email"
                :label="__('Email')"
                autofocus
        ></x-email-field>

        <x-password-field
                name="password"
                :label="__('Password')"
        ></x-password-field>

        <x-password-field
                name="password_confirmation"
                :label="__('Confirm your password')"
        ></x-password-field>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="flex justify-between items-center mt-2">
            <x-submit-button>
                {{ __('Reset') }}
            </x-submit-button>
        </div>
    </form-component>
@endcomponent
