@component('layouts.app', [
    'title' => $title ?? null,
    'fullWidth' => true,
])
    <nav class="bg-grey-lighter p-3 pt-4 flex">
        <active-link
            :href="action([\App\Admin\Controllers\AdminAnalyticsController::class, 'index'], ['sort' => '-view_count'])"
        >{{ __('Analytics') }}</active-link>

        <active-link
            :href="action([\App\Admin\Controllers\AdminSourcesController::class, 'index'])"
            class="ml-2"
        >{{ __('Sources') }}</active-link>

        <active-link
            :href="action([\App\Admin\Controllers\AdminTopicsController::class, 'index'])"
            class="ml-2"
        >{{ __('Topics') }}</active-link>

        <active-link
            :href="action([\App\Admin\Controllers\AdminTagsController::class, 'index'])"
            class="ml-2"
        >{{ __('Tags') }}</active-link>
    </nav>

    {{ $slot }}
@endcomponent
