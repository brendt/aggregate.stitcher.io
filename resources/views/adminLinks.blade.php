<?php
/** @var \Illuminate\Support\Collection|\App\Models\Link[] $links */
?>

@component('layout.app')

    <div class="mx-auto container grid gap-4 mt-4">
        @include('includes.adminMenu')

        <div class="bg-white mx-4 shadow-md max-w-full">
            @if($message)
                <div class="px-12 py-4 bg-green-100 font-bold block text-center">
                    {{ $message }}
                </div>
            @endif

            <a
                class="hover:bg-pink-200 px-12 py-4 font-bold block text-center"
                href="{{ action(\App\Http\Controllers\Links\CreateLinkController::class) }}"
                title="Add new link"
            >
                Add Link
            </a>

            @foreach ($links as $link)
                <div class="md:flex items-center">
                    <div class="block px-12 p-4 word-break">
                        <div class="flex align-baseline">
                            <h1 class="font-bold">
                                {{ $link->title }} <span class="text-sm">({{ $link->url }})</span>
                            </h1>
                        </div>

                        <div class="text-sm font-light text-gray-800 mt-2">
                        <span
                            x-data-url="{{ $link->getRedirectLink() }}"
                            class="cursor-pointer underline hover:no-underline link-copy"
                        >
                            {{ $link->getRedirectLink() }}
                        </span>
                        </div>
                        <div class="text-sm font-light text-gray-800 mt-2">
                            {{ $link->visits }} visits
                        </div>

                        <div class="flex gap-2 text-sm pt-2">
                            <a href="{{ $link->url }}"
                               class="underline hover:no-underline mr-4 py-2"
                            >
                                Show
                            </a>
                        </div>
                    </div>

                    <div class="mt-2 ml-0 lg:ml-8 lg:mt-0 ">
                        {!! $link->getSparkLine() !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const links = document.querySelectorAll('.link-copy');

        links.forEach(function (link) {
            initLink(link);
        })

        function initLink(link) {
            link.addEventListener('click', function () {
                removeCopiedLinkStyles();

                const url = link.getAttribute('x-data-url');

                try {
                    navigator.clipboard.writeText(url);
                } catch (e) {
                }

                link.classList.add('font-bold', 'text-green-600');
                link.classList.remove('underline');
                link.innerHTML = `Copied! ${url}`;
            })
        }

        function removeCopiedLinkStyles() {
            links.forEach(function (link) {
                const url = link.getAttribute('x-data-url');
                link.classList.remove('font-bold', 'text-green-600');
                link.classList.add('underline');
                link.innerHTML = url;
            })
        }
    </script>
@endcomponent
