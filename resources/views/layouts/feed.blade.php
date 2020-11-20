@component('layouts.app', [
    'title' => $title,
])
    <div class="flex items-baseline justify-between">
        <nav class="text-sm text-grey-darker leading-normal md:pt-2 h-12 flex items-center justify-between border-t md:border-t-0 border-b border-grey-lighter w-full">
            <ul class="flex w-full">
                <li class="mr-6">
                    <x-active-link
                            :href="action([\App\Feed\Controllers\PostsController::class, 'index'])"
                            :other="[
                            action([\App\Feed\Controllers\PostsController::class, 'all'])
                        ]"
                    >
                        {{ __('Discover') }}
                    </x-active-link>
                </li>
                <li class="mr-6">
                    <x-active-link
                            :href="action([\App\Feed\Controllers\PostsController::class, 'top'])"
                    >
                        {{ __('Top this week') }}
                    </x-active-link>
                </li>
                <li class="ml-auto">
                    <a
                            href="{{ action([\App\User\Controllers\GuestSourcesController::class, 'index']) }}"
                    >
                        <i class="far fa-lightbulb mr-2"></i>{{ __('Suggest a feed') }}
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    {{ $slot }}
@endcomponent
