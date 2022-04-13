<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto md:w-3/4 xl:w-1/3 w-full">
        @if($user)
            <div class="bg-white p-8 m-4 shadow-md grid gap-4 text-sm">
                <a
                    href="{{ action(\App\Http\Controllers\HomeController::class, [
                        $showDenied ? '' : 'denied'
                    ]) }}"
                    class="underline hover:no-underline"
                >
                    {{ $showDenied ? 'Hide denied' : 'Show denied' }}
                </a>

                <a
                    href="{{ action(\App\Http\Controllers\HomeController::class, [
                        $onlyPending ? '' : 'only_pending'
                    ]) }}"
                    class="underline hover:no-underline"
                >
                    {{ $onlyPending ? 'Show all' : 'Only pending' }}
                </a>
            </div>
        @endif
        <div class="bg-white p-8 m-4 shadow-md grid gap-4">
            @foreach ($posts as $post)
                <div>
                    <{{ $user ? 'div' : 'a' }}
                        href
                    ="{{ $post->url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="
                    block p-4
                    {{ $post->isPending() ? 'bg-gray-100' : '' }}
                    {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                    {{ $post->isStarred() ? 'hover:bg-yellow-300' : 'hover:bg-pink-100' }}
                    {{ $post->isDenied() ? 'bg-red-100' : '' }}
                    "
                    >
                    <h1 class="font-bold">
                        {{ $post->title }}
                        <span class="text-sm font-normal">— {{ $post->source->name }}</span>
                    </h1>

                    <div class="text-sm font-light text-gray-800">
                        @php
                            $diffInHours = $post->created_at->diffInHours(now())
                        @endphp

                        Published

                        @if($diffInHours <= 1)
                            right now
                        @elseif($diffInHours <= 24)
                            {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }} ago
                        @else
                            {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }} ago
                        @endif
                    </div>
                    @if($user)
                        <div class="flex gap-2 text-sm pt-2">
                            <a href="{{ $post->url }}"
                               class="underline hover:no-underline mr-4 py-2"
                               target="_blank" rel="noopener noreferrer"
                            >
                                Show
                            </a>

                            @if($post->canPublish())
                                <a href="{{ action(\App\Http\Controllers\PublishPostController::class, $post) }}"
                                   class="underline hover:no-underline text-green-600 mr-4 py-2"
                                >
                                    Publish
                                </a>
                            @endif

                            @if($post->canStar())
                                <a href="{{ action(\App\Http\Controllers\StarPostController::class, $post) }}"
                                   class="underline hover:no-underline text-yellow-500 mr-4 py-2"
                                >
                                    Star
                                </a>
                            @endif

                            @if($post->canDeny())
                                <a href="{{ action(\App\Http\Controllers\DenyPostController::class, $post) }}"
                                   class="underline hover:no-underline text-red-600 py-2"
                                >
                                    Deny
                                </a>
                            @endif
                        </div>
                    @endif
                </{{ $user ? 'div' : 'a' }}>
        </div>
        @endforeach

        <div class="flex justify-center mt-4">
            {{ $posts->onEachSide(0)->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    </div>
@endcomponent
