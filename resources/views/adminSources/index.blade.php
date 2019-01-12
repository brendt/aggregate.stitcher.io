@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Source\Models\Source[]|\Illuminate\Pagination\LengthAwarePaginator $sources */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
])
    <heading>{{ __('Sources') }}</heading>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th class="text-right">{{ __('Posts') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sources as $source)
                <tr>
                    <td class="w-2/5">
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
                            <span class="text-green">
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sources->render() }}
@endcomponent
