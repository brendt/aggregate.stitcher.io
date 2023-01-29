<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        @if($user)
            @include('includes.adminMenu')
        @endif

        <div class="bg-white mx-4 shadow-md grid">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <a
                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center add-link"
                href="{{ action(\App\Http\Controllers\Sources\SuggestSourceController::class) }}"
                title="Add your own"
            >
                <span class="add-sign">+</span>
                <span class="add-label">Make a suggestion…</span>
            </a>

            <div class="">
                @if ($user)
                    <div class="overflow-x-hidden block lg:px-12 p-4 md:flex border-b border-gray-200">
                        <div class="md:flex items-end">
                            <div>
                                <h1 class="font-bold break-words">
                                    Total visits: {{ $totalVisitsSparkLine->getTotal() }}
                                </h1>
                                <div class="text-sm font-light text-gray-800">
                                    {{ $totalVisitsSparkLine->getPeriod()?->start()->format('Y-m-d') }} — {{ $totalVisitsSparkLine->getPeriod()?->end()->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="mt-2 ml-0 lg:ml-8 lg:mt-0 ">
                                {!! $totalVisitsSparkLine !!}
                            </div>
                        </div>

                        <div class="md:flex items-end mt-8 md:ml-4">
                            <div>
                                <h1 class="font-bold break-words">
                                    Published posts: {{ $totalPostsSparkLine->getTotal() }}
                                </h1>
                                <div class="text-sm font-light text-gray-800">
                                    {{ $totalPostsSparkLine->getPeriod()?->start()->format('Y-m-d') }} — {{ $totalPostsSparkLine->getPeriod()?->end()->format('Y-m-d') }}
                                </div>
                            </div>
                            <div class="mt-2 ml-0 lg:ml-8 lg:mt-0 ">
                                {!! $totalPostsSparkLine !!}
                            </div>
                        </div>
                    </div>
                @endif

                @foreach ($posts as $post)
                    @auth()
                        @include('includes.postAdmin')
                    @else()
                        @include('includes.postGuest')
                    @endauth
                @endforeach
            </div>

            @if($posts->hasMorePages())
                <a class="px-12 py-4 font-bold block text-center hover:bg-pink-200" href="{{ $posts->nextPageUrl() }}"
                   title="Add your own">
                    more
                </a>
            @endif
        </div>
@endcomponent
