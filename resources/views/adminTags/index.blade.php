@php
    /** @var \Domain\Post\Models\Tag[]|\Illuminate\Pagination\LengthAwarePaginator $tags */
@endphp

@component('layouts.admin', [
    'title' => __('Tags'),
])
    <div class="flex justify-between">
        <x-heading>{{ __('Tags') }}</x-heading>

        <x-search-field
            :current-url="$currentUrl"
            :current-search-query="$currentSearchQuery"
        ></x-search-field>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>
                    <x-sort-link name="tags.name">
                        {{ __('Name') }}
                    </x-sort-link>
                </th>
                <th>
                    <x-sort-link name="topics.name">
                        {{ __('Topic') }}
                    </x-sort-link>
                </th>
                <th>
                    {{ __('Keywords') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tags as $tag)
                <tr>
                    <td>
                        <a href="{{ action([\App\Admin\Controllers\AdminTagsController::class, 'edit'], $tag->slug) }}" class="link">
                            {{ $tag->name }}
                        </a>
                    </td>
                    <td>
                        {{ $tag->topic->name }}
                    </td>
                    <td>
                        {{ \Illuminate\Support\Str::limit(implode(', ', $tag->getAllKeywords()), 100) }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right">
                    <a
                        href="{{ action([\App\Admin\Controllers\AdminTagsController::class, 'create']) }}"
                        class="button"
                    >
                        {{ __('New tag') }}
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>

    {{ $tags->render() }}
@endcomponent
