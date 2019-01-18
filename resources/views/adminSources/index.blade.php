@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
])
    <heading>{{ __('Sources') }}</heading>

    <div class="mt-6 mb-6">
        <filter-button
            name="is_active"
            value="0"
        >
            {{ __('Inactive sources') }}
        </filter-button>
    </div>

    <div>
        <form-component
            :action="action([\App\Http\Controllers\AdminSourcesController::class, 'store'])"
            class="flex items-baseline"
        >
            <text-field
                name="url"
                :label="__('RSS url')"
            ></text-field>

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
                    {{--<sort-link name="post_count">--}}
                        {{ __('Posts') }}
                    {{--</sort-link>--}}
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sources as $source)
                <tr>
                    <td>
                        <a
                            class="underline hover:no-underline"
                            href="{{ $source->url }}"
                            target="_blank"
                            rel="noopener noreferrer"
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
                            href="http://{{ $source->website }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >{{ $source->website }}</a>
                    </td>
                    <td class="text-right">
                        {{ $source->posts->count() }}
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

                        <br>

                        <a href="" class="">
                            Stats
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sources->render() }}
@endcomponent
