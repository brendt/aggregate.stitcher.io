@component('layouts.app', [
    'title' => __('Login'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Login') }}
    </h1>

    <form-component :action="route('login')">
        <email-field
            name="email"
            :label="__('Email')"
            autofocus
        ></email-field>

        <password-field
            name="password"
            :label="__('Password')"
        ></password-field>

        <div class="flex justify-between items-center mt-2">
            <checkbox-field
                name="remember"
                :label="__('Remember me')"
            ></checkbox-field>

            <submit-button>
                {{ __('Log in') }}
            </submit-button>
        </div>
    </form-component>

    <p class="mt-4 text-sm mt-8 text-grey-darker">
        {!! __('Don\'t have an account? <a href=":register_url" class="link">Register</a> instead.', [
            'register_url' => action([\App\User\Controllers\RegisterController::class, 'showRegistrationForm'])
        ]) !!}
    </p>

    <p class="mt-1 text-sm text-grey-darker">
        {!! __('Forgot your password? <a href=":register_url" class="link">Click here</a>.', [
            'register_url' => action([\App\User\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])
        ]) !!}
    </p>
@endcomponent
