@component('layouts.app', [
    'title' => __('Logout'),
])
    <div class="flex justify-center">
        <form-component
            :action="action([\App\Http\Controllers\Auth\LoginController::class, 'logout'])"
            class="
                p-2 w-2/5
            "
        >
            <p class="mb-3">
                {{ __('Are you sure you want to log out?') }}
            </p>

            <submit-button>
                {{ __('Logout') }}
            </submit-button>
        </form-component>
    </div>
@endcomponent
