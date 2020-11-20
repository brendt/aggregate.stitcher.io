@component('layouts.app', [
    'title' => __('Password reset'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Password reset') }}
    </h1>

    <x-form-component :action="route('password.email')">
        <x-email-field
                name="email"
                :label="__('Email')"
                autofocus
        ></x-email-field>

        <div class="flex justify-between items-center mt-2">
            <x-submit-button>
                {{ __('Reset') }}
            </x-submit-button>
        </div>
    </x-form-component>
@endcomponent
