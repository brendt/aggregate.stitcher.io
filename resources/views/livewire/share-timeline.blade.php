<div class="mx-4 bg-white p-4 flex gap-1 overflow-x-scroll">
    @foreach($postSharesPerDay as $day => $shares)
        <div class="bg-gray-100 shrink-0 p-4 py-3" style="min-width:40px;">
            <span class="font-bold">
                {{ $day }}
            </span>

            @foreach($shares as $share)
                <br>
                {{ $share->post->title }}
                ({{ $share->channel }})
            @endforeach
        </div>
    @endforeach
</div>
