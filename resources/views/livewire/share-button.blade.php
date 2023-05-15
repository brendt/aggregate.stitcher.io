<div class="relative">
    <x-tag
        class="cursor-pointer"
        :color="$postShare ? 'green' : 'orange'"
        wire:click="showModal()" wire:keydown.Escape="hideModal()"
    >
        @if($postShare)
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-green-500">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/>
            </svg>

            <span class="text-gray-800 ml-2">
                Scheduled
            </span>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                <path d="M13 4.5a2.5 2.5 0 11.702 1.737L6.97 9.604a2.518 2.518 0 010 .792l6.733 3.367a2.5 2.5 0 11-.671 1.341l-6.733-3.367a2.5 2.5 0 110-3.475l6.733-3.366A2.52 2.52 0 0113 4.5z"/>
            </svg>

            <span class="text-gray-800 ml-2">
                Share
            </span>
        @endif
    </x-tag>

    @if($modalShown)
        <div class="modal">
            <div class="popup p-2 bg-gray-200 text-base border-2 border-gray-700 rounded grid grid-cols-3 gap-2">
                <select name="channel" id="channel" class="col-span-2 rounded border" wire:model="form.channel">
                    <option value="" selected=""></option>
                    @foreach($this->channels as $channel)
                        <option value="{{ $channel->value }}">{{ $channel->name }}</option>
                    @endforeach
                </select>

                <button
                    class="font-bold cursor-pointer hover:bg-orange-200 hover:border-orange-300 bg-orange-100 rounded border border-orange-400 py-1 px-2 flex items-center justify-center"
                    wire:click.prevent="storeForm()"
                >
                    Schedule
                </button>

                @if($nextTimeslot)
                    <div class="text-sm col-span-3 text-right">
                        Next timeslot: {{ $nextTimeslot->format('Y-m-d H:i') }}
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
