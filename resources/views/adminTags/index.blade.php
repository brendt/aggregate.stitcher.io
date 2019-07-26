@php
    /** @var \Domain\Post\Models\Tag[]|\Illuminate\Pagination\LengthAwarePaginator $tags */
@endphp

@component('layouts.admin', [
    'title' => __('Tags'),
])
    <div class="flex justify-between">
        <heading>{{ __('Tags') }}</heading>

        <search-field
            :current-url="$currentUrl"
            :current-search-query="$currentSearchQuery"
        ></search-field>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>
                    <sort-link name="tags.name">
                        {{ __('Name') }}
                    </sort-link>
                </th>
                <th>
                    <sort-link name="topics.name">
                        {{ __('Topic') }}
                    </sort-link>
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
                        <a href="{{ action([\App\Http\Controllers\AdminTagsController::class, 'edit'], $tag->slug) }}" class="link">
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
                        href="{{ action([\App\Http\Controllers\AdminTagsController::class, 'create']) }}"
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
