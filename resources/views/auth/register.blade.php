@component('layouts.app', [
    'title' => __('Register'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Register') }}
    </h1>

    <p class="mb-8 leading-normal">
        {{ __("By registering an account, you'll be able to vote for posts and submit your own blog.") }}
    </p>

    <form-component :action="route('register')">
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
            :label="__('Repeat password')"
        ></password-field>

        <div class="flex justify-end items-center mt-2">
            <submit-button>
                {{ __('Register') }}
            </submit-button>
        </div>
    </form-component>

    <p class="mt-4 text-sm mt-8 text-grey-darker">
        {!! __('Already have an account? <a href=":register_url" class="link">Log in</a> instead.', [
            'register_url' => action([\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])
        ]) !!}
    </p>
@endcomponent
