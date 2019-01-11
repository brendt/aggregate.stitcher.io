@component('layouts.app', [
    'title' => __('Register'),
])
    <heading>{{ __('Register') }}</heading>

    <div class="flex">
        <form-component
            :action="route('register')"
            class=""
        >
            <email-field
                name="email"
                :label="__('Email')"
                autofocus
                :value="'brent+' . random_int(0, 1000) . '@stitcher.io'"
            ></email-field>

            <password-field
                name="password"
                :label="__('Password')"
                value="secret"
            ></password-field>

            <password-field
                name="password_confirmation"
                :label="__('Password')"
                value="secret"
            ></password-field>

            <div class="flex justify-between items-center">
                <submit-button>
                    {{ __('Submit') }}
                </submit-button>
            </div>
        </form-component>
    </div>
@endcomponent
