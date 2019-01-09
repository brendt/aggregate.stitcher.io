@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Mute\Models\Mute[] $mutes */
@endphp

@component('layouts.app', [
    'title' => __('Mutes'),
])
    <h2 class="text-xl mt-4 mb-2">Mutes</h2>

    @if(!count($mutes))
        <p>{{ __('You have no mutes configured.') }}</p>
    @endif

    <table class="table">
        <tbody>
            @foreach ($mutes as $mute)
                <tr>
                    <td>
                        @if($mute->getMuteable() instanceof \Domain\Post\Models\Tag)
                            <span
                                class="tag"
                                style="--tag-color: {{ $mute->getMuteable()->color }}"
                            >
                                {{ $mute->getMuteable()->getName() }}
                            </span>
                        @else
                            {{ $mute->getMuteable()->getName() }}
                        @endif
                    </td>
                    <td class="text-right">
                        <post-button
                            :action="$mute->getMuteable()->getUnmuteUrl()"
                        >
                            <span class="underline hover:no-underline text-grey-darker text-sm">
                                {{ __('Unmute') }}
                            </span>
                        </post-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endcomponent
