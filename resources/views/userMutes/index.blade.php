@php
    /** @var \Domain\User\Models\User $user */
    /** @var \Domain\Mute\Models\Mute[] $mutes */
@endphp

@component('layouts.app', [
    'title' => __('Mutes'),
])
    <table class="table">
        <tbody>
            @foreach ($mutes as $mute)
                <tr>
                    <td>
                        {{ $mute->getMuteable()->getName() }}
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
