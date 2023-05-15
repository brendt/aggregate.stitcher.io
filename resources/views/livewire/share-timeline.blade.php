@php
    /** @var \App\Models\PostShare $share */
@endphp

<div class="mx-4 bg-white p-4 flex gap-1 overflow-x-scroll">
    @foreach($postSharesPerDay as $day => $shares)
        <div class="bg-gray-50 {{ count($shares) ? 'border-orange-300' : '' }} border rounded shrink-0 p-4 py-3" style="min-width:40px;">
            <span class="font-bold">
                {{ $day }}
            </span>

            @foreach($shares as $share)
                <br>
                @if($share->channel === \App\Services\PostSharing\SharingChannel::HackerNews)
                    <a class="underline hover:no-underline" href="https://news.ycombinator.com/submitlink?u={{$share->post->getFullUrl()}}&t={{$share->post->title}}">
                        {{ $share->post->title }}
                        ({{ $share->channel }})
                    </a>
                @else
                    {{ $share->post->title }}
                    ({{ $share->channel }})
                @endif
            @endforeach
        </div>
    @endforeach
</div>
