@component('layouts.app', [
    'title' => __('Register'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Register') }}
    </h1>

    <div class="content">
        <p>
            By registering you'll be able to fine-tune the feed to your wishes.
            You're able to vote for posts you like and mute feeds you're not interested in.
        </p>

        <p>
            You're also able to submit your own feed, which will then show up on aggregate.
            Do you want to know more about how aggregate works before registering?
            You can read about it <a href="{{ action(\App\Feed\Controllers\AboutController::class) }}" target="_blank"
                                     rel="noopener noreferrer">here</a>.
        </p>
    </div>

    <x-form-component :action="route('register')" class="mt-8">
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
                :label="__('Repeat password')"
        ></x-password-field>

        <div class="flex justify-end items-center mt-2">
            <x-submit-button>
                {{ __('Register') }}
            </x-submit-button>
        </div>
    </x-form-component>

    <p class="mt-4 text-sm mt-8 text-grey-darker">
        {!! __('Already have an account? <a href=":register_url" class="link">Log in</a> instead.', [
            'register_url' => action([\App\User\Controllers\LoginController::class, 'showLoginForm'])
        ]) !!}
    </p>
@endcomponent
