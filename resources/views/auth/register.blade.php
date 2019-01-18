@component('layouts.app', [
    'title' => __('Register'),
])
    <heading>{{ __('Register') }}</heading>

    <p class="mt-4 w-4/5">
        {{ __("By registering an account, you'll be able to submit your own RSS link, and we'll add your links to the overview.") }}

        {!! __('Already have an account? Click <a href=":register_url" class="link">here</a> to login.', [
            'register_url' => action([\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
        ]) !!}
    </p>

    <div class="flex mt-4">
        <form-component
            :action="route('register')"
            class=""
        >
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
                :label="__('Password')"
            ></password-field>

            <div class="flex justify-between items-center mt-4">
                <submit-button>
                    {{ __('Submit') }}
                </submit-button>
            </div>
        </form-component>
    </div>
@endcomponent
