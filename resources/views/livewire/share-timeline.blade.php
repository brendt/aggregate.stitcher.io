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

                        @if($share->channel === SharingChannel::HackerNews)
                            <a class="underline hover:no-underline" href="https://news.ycombinator.com/submitlink?u={{$share->post->getFullUrl()}}&t={{$share->post->title}}">
                                {{ $share->post->getTruncatedTitle() }}
                            </a>
                        @else
                            {{ $share->post->getTruncatedTitle() }}
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    @endforeach
</div>
