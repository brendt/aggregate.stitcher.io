@component('layouts.app', [
    'title' => __('Logout'),
])
    <form
        action="{{ action([\App\Http\Controllers\Auth\LoginController::class, 'logout']) }}"
        method="post"
    >
        @csrf

        <button type="submit">
            {{ __('Logout') }}
        </button>
    </form>
@endcomponent
