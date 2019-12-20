@php
    /** @var \Domain\Post\Models\Topic[]|\Illuminate\Pagination\LengthAwarePaginator $topics */
@endphp

@component('layouts.admin', [
    'title' => __('Topics'),
])
    <div class="flex justify-between">
        <heading>{{ __('Topics') }}</heading>

        <search-field
            :current-url="$currentUrl"
            :current-search-query="$currentSearchQuery"
        ></search-field>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>
                    <sort-link name="topics.name">
                        {{ __('Name') }}
                    </sort-link>
                </th>
                <th>
                    {{ __('Tags') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($topics as $topic)
                <tr>
                    <td>
                        <a href="{{ action([\App\Admin\Controllers\AdminTopicsController::class, 'edit'], $topic->slug) }}" class="link">
                            {{ $topic->name }}
                        </a>
                    </td>
                    <td>
                        {{ implode(', ', $topic->tags->map(function (\Domain\Post\Models\Tag $tag) {
                            return $tag->name;
                        })->toArray()) }}
                    </td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td></td>
                <td class="text-right">
                    <a
                        href="{{ action([\App\Admin\Controllers\AdminTopicsController::class, 'create']) }}"
                        class="button"
                    >
                        {{ __('New topic') }}
                    </a>
                </td>
            </tr>
        </tfoot>
    </table>

    {{ $topics->render() }}
@endcomponent
