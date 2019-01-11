@component('layouts.app', [
    'title' => __('Unverified'),
])
    <heading>{{ __('Verify your account') }}</heading>

    <p class="mt-4">
        {{ __('Your account must be verified in order to view this page.') }}
    </p>

    <post-button
        :action="action([\App\Http\Controllers\UserVerificationController::class, 'resend'])"
        class="button mt-4"
    >
        {{ __('Resend the verification mail') }}
    </post-button>
@endcomponent
