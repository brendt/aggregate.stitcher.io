@component('layouts.app', [
    'title' => __('Password reset'),
])
    <h1 class="font-title text-2xl mt-4 mb-8">
        {{ __('Password reset') }}
    </h1>

    <form-component :action="route('password.email')">
        <email-field
            name="email"
            :label="__('Email')"
            autofocus
        ></email-field>

        <div class="flex justify-between items-center mt-2">
            <submit-button>
                {{ __('Reset') }}
            </submit-button>
        </div>
    </form-component>
@endcomponent
