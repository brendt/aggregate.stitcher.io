@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.admin', [
    'title' => __('Sources'),
])
    <div class="md:flex md:justify-between md:items-baseline">
        <heading class="mt-4 md:mt-0">{{ __('Sources') }}</heading>

        <search-field
            :current-url="$currentUrl"
            :current-search-query="$currentSearchQuery"
        ></search-field>
    </div>

    <div class="md-max:mt-2">
        <filter-button
            name="is_active"
            value="0"
        >
            {{ __('Show only inactive sources') }}
        </filter-button>
    </div>

    <table class="table mt-4 truncate">
        <thead class="md-max:hidden">
            <tr>
                <th>
                    <sort-link name="url">
                        {{ __('Name') }}
                    </sort-link>
                </th>
                <th>
                    <sort-link name="is_validated">
                        {{ __('Feed') }}
                    </sort-link>
                </th>
                <th>
                    {{ __('Topics') }}
                </th>
                <th class="text-right lg-max:hidden">
                    <sort-link name="post_count">
                        {{ __('Posts') }}
                    </sort-link>
                </th>
                <th class="text-right  lg-max:hidden">
                    <sort-link name="created_at">
                        {{ __('Date created') }}
                    </sort-link>
                </th>
                <th>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sources as $source)
                <tr class="md-max:flex">
                    <td class="md-max:w-full">
                        <a
                            class="
                                link
                                inline-block
                                mt-1
                            "
                            href="{{ $source->getAdminUrl() }}"
                        >{{ $source->website }}</a>

                        @php
                            $errorsLastWeek = $source->getErrorLogs()->lastWeek();
                        @endphp

                        @if($errorsLastWeek->isNotEmpty())
                             <a
                                 href="{{ action([\App\Http\Controllers\AdminErrorLogController::class, 'index'], ['type' => $source->getMorphClass(), 'id' => $source->getKey()]) }}"
                                 class="text-sm text-red"
                             >
                                 {{ $errorsLastWeek->count() }} {{ \Illuminate\Support\Str::plural('error', $errorsLastWeek->count()) }} last week
                             </a>
                        @endif
                    </td>
                    <td class="md-max:hidden">
                        @if($source->is_validated)
                            <a href="{{ $source->url }}" target="_blank" rel="noopener noreferrer" class="link">
                                {{ $source->url }}
                            </a>
                        @elseif($source->validation_failed_at)
                            <span class="text-red">
                                {{ __('No valid RSS found') }}
                            </span>
                        @else
                            <span class="text-grey-darker">
                                {{ __('Feed validation pending…') }}
                            </span>
                        @endif
                    </td>
                    <td class="md-max:hidden">
                        {{ $source->topics->implode('name', ', ') }}
                    </td>
                    <td class="text-right md-max:hidden lg-max:hidden">
                        {{ $source->post_count }}
                    </td>
                    <td class="text-right md-max:hidden  lg-max:hidden">
                        {{ $source->created_at->toDateTimeString() }}
                    </td>
                    <td class="text-right md-max:hidden">
                        @if ($source->is_active)
                            <span class="text-green font-bold">
                                {{ __('Active') }}
                            </span>
                        @elseif($source->is_validated)
                            <post-button
                                class="button button-small button-green"
                                :action="action([\App\Http\Controllers\AdminSourcesController::class, 'activate'], $source->uuid)"
                            >
                                {{ __('Activate') }}
                            </post-button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <form-component
            :action="action([\App\Http\Controllers\AdminSourcesController::class, 'store'])"
            class="md:flex md:items-bottom md:justify-end"
        >
            <div class="md:hidden">
                <label for="url">{{ __('Source URL:') }}</label>
            </div>

            <text-field
                name="url"
                label=""
            ></text-field>

            <submit-button class="md:ml-4 button-small">
                <span class="md:hidden">
                    {{ __('Add') }}
                </span>
                <span class="md-max:hidden">
                    {{ __('Add source') }}
                </span>
            </submit-button>
        </form-component>
    </div>

    {{ $sources->render() }}
@endcomponent
