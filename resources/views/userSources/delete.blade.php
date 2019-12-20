@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.admin', [
    'title' => __('Delete feed'),
])
    <heading>{{ __("Are you sure you want to delete your feed?") }}</heading>

    <div class="content">
        <p>All data related to your feed, views and votes will be removed.</p>
    </div>

    <div class="mt-4">
        <form-component
            :action="action([\App\User\Controllers\UserSourcesController::class, 'delete'], $source)"
            class="flex items-baseline"
        >
            <submit-button class="button-small bg-red-dark">
                {{ __('Yes, delete') }}
            </submit-button>

            <a
                href="{{ action([\App\User\Controllers\UserSourcesController::class, 'index']) }}"
                class="ml-3"
            >
                {{ __('Cancel') }}
            </a>
        </form-component>
    </div>
@endcomponent
