@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.admin', [
    'title' => __('Delete feed'),
])
    <x-heading>{{ __("Are you sure you want to delete your feed?") }}</x-heading>

    <div class="content">
        <p>All data related to your feed, views and votes will be removed.</p>
    </div>

    <div class="mt-4">
        <x-form-component
                :action="action([\App\User\Controllers\UserSourcesController::class, 'delete'], $source)"
                class="flex items-baseline"
        >
            <x-submit-button class="button-small bg-red-dark">
                {{ __('Yes, delete') }}
            </x-submit-button>

            <a
                    href="{{ action([\App\User\Controllers\UserSourcesController::class, 'index']) }}"
                    class="ml-3"
            >
                {{ __('Cancel') }}
            </a>
        </x-form-component>
    </div>
@endcomponent
