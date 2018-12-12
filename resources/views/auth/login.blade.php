@component('layouts.app', [
    'title' => __('Login'),
])
    <div class="flex justify-center">
        <form-component
            :action="route('login')"
            class="
                p-2 w-2/5
                border border-black
            "
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
                <checkbox-field
                    name="remember"
                    :label="__('Remember me')"
                    class="mb-2 mt-4"
                ></checkbox-field>
            </div>

            <div class="flex justify-between items-center">
                <a class="text-blue hover:text-blue-dark" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>

                <submit-button>
                    {{ __('Login') }}
                </submit-button>
            </div>
        </form-component>
    </div>
@endcomponent
