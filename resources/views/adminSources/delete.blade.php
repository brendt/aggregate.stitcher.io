@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.admin', [
    'title' => __('Delete source'),
])
    <x-heading>{{ __("Delete source {$source->website}?") }}</x-heading>

    <div class="mt-4">
        <form-component
                :action="action([\App\Admin\Controllers\AdminSourcesController::class, 'delete'], $source)"
                class="flex items-baseline"
        >
            <x-submit-button class="button-small bg-red-dark">
                {{ __('Yes, delete') }}
            </x-submit-button>

            <a
                    href="{{ action([\App\Admin\Controllers\AdminSourcesController::class, 'edit'], $source->uuid) }}"
                    class="ml-3"
            >
                {{ __('Cancel') }}
            </a>
        </form-component>
    </div>
@endcomponent
