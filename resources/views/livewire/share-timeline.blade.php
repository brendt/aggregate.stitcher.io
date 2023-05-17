@php use Carbon\Carbon; @endphp
@php use App\Services\PostSharing\SharingChannel; @endphp
@php
    /** @var \App\Models\PostShare $share */
@endphp

<div class="
    mx-4
    bg-white
    p-4
    flex
    flex-col
    md:flex-row
    text-sm
    md:text-md
    gap-1
    overflow-x-scroll
    shadow
    border-orange-300
    ">
    @foreach($timeline as $month => $sharesPerDay)
        <div class="font-bold mx-4 flex items-center">
            <span>
            {{ Carbon::make($month)->format('M') }}
            </span>
        </div>

        @foreach($sharesPerDay as $date => $shares)
            @php($date = Carbon::make($date))

            <div class="
                bg-gray-50
                {{ $date->copy()->endOfDay()->isPast() ? 'text-gray-400' : '' }}
                {{ $date->isFuture() ? 'text-gray-600' : '' }}
                {{ $date->isToday() ? 'border-orange-300 border-2 text-black' : '' }}
                {{ count($shares) === 0 ? 'hidden md:block' : '' }}
                border
                rounded shrink-0 p-4 py-3
                flex flex-col gap-2
                "
            >
                <span class="font-bold">
                    {{ Carbon::make($date)->format('d') }}
                </span>

                @foreach($shares as $share)
                    <div class="flex gap-1 items-center">
                        {!! $share->channel->getIcon() !!}

                        <span class="text-xs">{{ $share->share_at->format("H:i") }}</span>

                        @if($share->channel === SharingChannel::HACKERNEWS)
                            <a class="underline hover:no-underline"
                               href="https://news.ycombinator.com/submitlink?u={{$share->post->getFullUrl()}}&t={{$share->post->title}}">
                                {{ $share->post->getTruncatedTitle() }}
                            </a>
                        @else
                            {{ $share->post->getTruncatedTitle() }}
                        @endif
                        <div class="flex gap-1 md:gap-0">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-5 h-5 cursor-pointer hover:text-green-600"
                                 wire:click="markAsShared({{ $share->id }})">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="w-5 h-5 cursor-pointer hover:text-red-600"
                                 wire:click="markAsRemoved({{ $share->id }})">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach
</div>
