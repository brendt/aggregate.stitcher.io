@component('layouts.app', [
    'title' => __('Password reset'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Choose a new password') }}
    </h1>

    <form-component :action="route('password.update')">
        <email-field
            name="email"
            :label="__('Email')"
            autofocus
        ></email-field>

        <password-field
            name="password"
            :label="__('Password')"
        ></password-field>

        <password-field
            name="password_confirmation"
            :label="__('Confirm your password')"
        ></password-field>

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="flex justify-between items-center mt-2">
            <submit-button>
                {{ __('Reset') }}
            </submit-button>
        </div>
    </form-component>
@endcomponent
