@component('layouts.app', [
    'title' => __('Login'),
])
    <heading>{{ __('Login') }}</heading>

    <div class="flex mt-4">
        <form-component
            :action="route('login')"
        >
            <email-field
                name="email"
                :label="__('Email')"
                autofocus
            ></email-field>

            <password-field
                name="password"
                :label="__('Password')"
                autofocus
            ></password-field>

            <div class="">
            </div>

            <div class="flex justify-between items-center mt-4">
                {{--<a class="text-blue hover:text-blue-dark" href="{{ route('password.request') }}">--}}
                    {{--{{ __('Forgot Your Password?') }}--}}
                {{--</a>--}}
                <checkbox-field
                    name="remember"
                    :label="__('Remember me')"
                    class="mb-2 mt-4"
                ></checkbox-field>

                <submit-button>
                    {{ __('Login') }}
                </submit-button>
            </div>
        </form-component>
    </div>

    <p class="mt-4">
        {!! __('No account yet? Click <a href=":register_url" class="link">here</a> to register.', [
            'register_url' => action([\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])
        ]) !!}
    </p>
@endcomponent
