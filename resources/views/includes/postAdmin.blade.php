@php
    $hoverColor = match(true) {
        $post->isStarred() => 'yellow-300',
        $post->isTweet() => 'blue-100',
        default => 'pink-100',
    };

    /** @var \App\Models\Post $post */
@endphp

<div class="overflow-x-hidden border-b border-gray-200 pt-2">
    <div
        class="
            word-break
            block lg:px-12 p-4
        "
    >
        <div class="md:flex items-end">
            <div class="break-words">
                <h1 class="font-bold break-words">
                    {{ $post->getParsedTitle() }}
                    <span class="text-sm font-light">
                        — {{ $post->getShortSourceName() }}
                    </span>
                </h1>

                <x-tags class="flex-wrap mt-1">
                    <livewire:share-button :post="$post"></livewire:share-button>

                    {!! $buttons ?? null !!}

                    @include('includes.postButtons')

                    @if($showDeny ?? true)
                        @if($post->canDeny())
                            <x-tag
                                :url="action(\App\Http\Controllers\Posts\DenyPostController::class, ['post' => $post, ...request()->query->all()])"
                                color="red"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">
                                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/>
                                </svg>

                                <span class="ml-1 text-gray-800">
                                    Deny
                                </span>
                            </x-tag>
                        @endif
                    @endif

                    <x-tag
                        x-data-url="{{ $post->getPublicUrl() }}"
                        class="link-copy cursor-pointer hover:bg-gray-200 hover:border-gray-300"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400">
                            <path fill-rule="evenodd" d="M13.887 3.182c.396.037.79.08 1.183.128C16.194 3.45 17 4.414 17 5.517V16.75A2.25 2.25 0 0114.75 19h-9.5A2.25 2.25 0 013 16.75V5.517c0-1.103.806-2.068 1.93-2.207.393-.048.787-.09 1.183-.128A3.001 3.001 0 019 1h2c1.373 0 2.531.923 2.887 2.182zM7.5 4A1.5 1.5 0 019 2.5h2A1.5 1.5 0 0112.5 4v.5h-5V4z" clip-rule="evenodd"/>
                        </svg>

                        <span class="ml-1 text-gray-800">
                            Copy Link
                        </span>
                    </x-tag>

                    @if($showHide ?? false)
{{--                        <x-tag--}}
{{--                            :url="action(\App\Http\Controllers\Posts\HidePostController::class, $post)"--}}
{{--                            color="green"--}}
{{--                        >--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-500">--}}
{{--                                <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z"/>--}}
{{--                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>--}}
{{--                            </svg>--}}

{{--                            <span class="ml-1 text-gray-800">--}}
{{--                                Hide--}}
{{--                            </span>--}}
{{--                        </x-tag>--}}


                    @endif

{{--                    <div class="bg-gray-100 rounded py-1 px-2 flex items-center justify-center" style="color:#fff; background-color:hsl(110 ,{{ $post->getRanking()->getSaturation() }}%, 34%)">--}}
{{--                        {!! $post->getRanking() !!}--}}
{{--                    </div>--}}

{{--                    <div class="">--}}
{{--                        {!! $post->getSparkLine() !!}--}}
{{--                    </div>--}}
                </x-tags>
            </div>
        </div>
    </div>
</div>
