@component('layouts.app', [
    'title' => __('Unverified'),
])
    <x-heading>{{ __('Verify your account') }}</x-heading>

    <p class="mt-4">
        {{ __('Your account must be verified in order to view this page.') }}
    </p>

    <x-post-button
        :action="action([\App\User\Controllers\UserVerificationController::class, 'resend'])"
        class="button mt-4"
    >
        {{ __('Resend the verification mail') }}
    </x-post-button>
@endcomponent
