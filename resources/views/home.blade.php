<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-2 md:mt-4">
        @if($user->is_admin ?? null)
            @include('includes.adminMenu')
        @elseif($user)
            @include('includes.userMenu')
        @endif

        <div class="bg-white mx-1 md:mx-4 shadow-md grid">
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
                @if (($user->is_admin ?? false) && ($totalVisitsSparkLine ?? null))
                    <div class="overflow-x-hidden lg:px-12 p-4 border-b border-gray-200">
                        <h1 class="font-bold break-words">
                            {{ $totalVisitsSparkLine->getPeriod()?->start()->format('Y-m-d') }} — {{ $totalVisitsSparkLine->getPeriod()?->end()->format('Y-m-d') }}
                        </h1>

                        <div class="lg:flex justify-between">
                            <div class="md:flex items-end">
                                <div class="text-sm font-light text-gray-800">
                                    Visits this period: {{ $totalVisitsSparkLine->getTotal() }}
                                </div>
                                <div class="mt-4 lg:mt-0 ml-0 lg:ml-8">
                                    {!! $totalVisitsSparkLine !!}
                                </div>
                            </div>

                            <div class="md:flex items-end mt-8">
                                <div class="text-sm font-light text-gray-800">
                                    Published posts this period: {{ $totalPostsSparkLine->getTotal() }}
                                </div>
                                <div class="mt-4 lg:mt-0 ml-0 lg:ml-8">
                                    {!! $totalPostsSparkLine !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @foreach ($posts as $post)
                    @if($user->is_admin ?? false)
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

    @auth()
        @include('includes.copyLink')
        <script>
            document.addEventListener('keydown', (e) => Livewire.emit('handleKeypress', e.code));
        </script>
    @endauth
@endcomponent
