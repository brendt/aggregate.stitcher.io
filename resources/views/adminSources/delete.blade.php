@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.admin', [
    'title' => __('Delete source'),
])
    <heading>{{ __("Delete source {$source->website}?") }}</heading>

    <div class="mt-4">
        <form-component
            :action="action([\App\Http\Controllers\AdminSourcesController::class, 'delete'], $source)"
            class="flex items-baseline"
        >
            <submit-button class="button-small bg-red-dark">
                {{ __('Yes, delete') }}
            </submit-button>

            <a
                href="{{ action([\App\Admin\Controllers\AdminSourcesController::class, 'edit'], $source->uuid) }}"
                class="ml-3"
            >
                {{ __('Cancel') }}
            </a>
        </form-component>
    </div>
@endcomponent
