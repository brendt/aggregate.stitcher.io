<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @include('includes.adminMenu')

        <div class="bg-white mx-4 shadow-md grid">
            <div>
                @foreach ($source->posts as $post)
                    <div>
                        <div
                            class="
                        block px-12 p-4
                        {{ $post->isPending() ? 'bg-gray-200' : '' }}
                        {{ $post->isStarred() ? 'bg-yellow-100' : '' }}
                        {{ $post->isDenied() ? 'bg-red-100' : '' }}
                        "
                        >
                            <h1 class="font-bold break-words">
                                {{ $post->title }}
                            </h1>

                            <div class="text-sm font-light text-gray-800">
                                {{ $post->getSourceName() }},

                                @php
                                    $diffInHours = $post->created_at->diffInHours(now())
                                @endphp

                                published

                                @if($diffInHours <= 1)
                                    right now
                                @elseif($diffInHours <= 24)
                                    {{ $diffInHours }} {{ \Illuminate\Support\Str::plural('hour', $diffInHours) }} ago
                                @else
                                    {{ $post->created_at->diffInDays(now()) }} {{ \Illuminate\Support\Str::plural('day', $post->created_at->diffInDays(now())) }}
                                    ago
                                @endif

                                {{ $post->visits }} visits
                            </div>

                            <div class="flex gap-2 text-sm pt-2">
                                <a href="{{ $post->url }}"
                                   class="underline hover:no-underline mr-4 py-2"
                                >
                                    Show
                                </a>

                                @if($post->canPublish())
                                    <a href="{{ action(\App\Http\Controllers\Posts\PublishPostController::class, [
                                        'post' => $post,
                                        'ref' => action(\App\Http\Controllers\Sources\AdminSourceDetailController::class, $source),
                                        ...request()->query->all()
                                    ]) }}"
                                       class="underline hover:no-underline text-green-600 mr-4 py-2"
                                    >
                                        Publish
                                    </a>
                                @endif

                                @if($post->canStar())
                                    <a href="{{ action(\App\Http\Controllers\Posts\StarPostController::class, [
                                        'post' => $post,
                                        'ref' => action(\App\Http\Controllers\Sources\AdminSourceDetailController::class, $source),
                                        ...request()->query->all(),
                                    ]) }}"
                                       class="underline hover:no-underline text-yellow-500 mr-4 py-2"
                                    >
                                        Star
                                    </a>
                                @endif

                                @if($post->canDeny())
                                    <a href="{{ action(\App\Http\Controllers\Posts\DenyPostController::class, [
                                        'post' => $post,
                                        'ref' => action(\App\Http\Controllers\Sources\AdminSourceDetailController::class, $source),
                                        ...request()->query->all(),
                                    ]) }}"
                                       class="underline hover:no-underline text-red-600 py-2"
                                    >
                                        Deny
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
@endcomponent
