@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
    'fullWidth' => true,
])
    <heading>{{ __('Sources') }}</heading>

    <div class="mt-4">
        <form-component
            :action="action([\App\Http\Controllers\AdminSourcesController::class, 'store'])"
            class="flex items-baseline"
        >
            <text-field
                name="url"
                :label="__('RSS url')"
            ></text-field>

            <div class="ml-3">
                <select-field
                        name="language"
                        :label="__('Language')"
                >
                    @foreach(get_supported_languages() as $code => $language)
                        <option value="{{ $code }}">{{ $language['native'] }}</option>
                    @endforeach
                </select-field>
            </div>

            <submit-button class="ml-4 button-small">
                {{ __('Add source') }}
            </submit-button>
        </form-component>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>
                    <sort-link name="url">
                        {{ __('Name') }}
                    </sort-link>
                </th>
                <th class="text-right">
                    <sort-link name="post_count">
                        {{ __('Posts') }}
                    </sort-link>
                </th>
                <th class="text-right">
                    <sort-link name="created_at">
                        {{ __('Date created') }}
                    </sort-link>
                </th>
                <th class="text-right">
                    <filter-button
                        name="is_active"
                        value="0"
                    >
                        {{ __('Inactive sources') }}
                    </filter-button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sources as $source)
                <tr>
                    <td>
                        <a
                            class="underline hover:no-underline"
                            href="{{ $source->url }}"
                        >
                            {{ $source->url }}
                        </a>
                        <br>
                        <a
                            class="
                                underline
                                hover:no-underline
                                text-grey-darker
                                inline-block
                                mt-1
                            "
                            href="{{ $source->website }}"
                        >{{ $source->website }}</a>
                    </td>
                    <td class="text-right">
                        {{ $source->post_count }}
                    </td>
                    <td class="text-right">
                        {{ $source->created_at->toDateTimeString() }}
                    </td>
                    <td class="text-right">
                        @if ($source->is_active)
                            <span class="text-green font-bold">
                                {{ __('active') }}
                            </span>
                        @else
                            <post-button
                                class="button button-small button-green"
                                :action="action([\App\Http\Controllers\AdminSourcesController::class, 'activate'], $source->uuid)"
                            >
                                {{ __('Activate') }}
                            </post-button>
                        @endif

                        {{--<br>--}}

                        {{--<a href="" class="">--}}
                            {{--Stats--}}
                        {{--</a>--}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sources->render() }}
@endcomponent
