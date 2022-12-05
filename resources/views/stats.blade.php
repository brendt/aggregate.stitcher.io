<?php
/** @var \Illuminate\Support\Collection|\App\Models\Post[] $posts */
?>

@component('layout.app')
    <div class="mx-auto container grid gap-4 mt-4">
        <div class="bg-white mx-4 shadow-md grid">
            <div class="overflow-x-hidden block lg:px-12 p-4 md:flex">
                <div class="md:flex items-end">
                    <div>
                        <h1 class="font-bold break-words">
                            Total visits: {{ $sparkLine->getTotal() }}
                        </h1>
                        <div class="text-sm font-light text-gray-800">
                            {{ $sparkLine->getPeriod()->start()->format('Y-m-d') }} — {{ $sparkLine->getPeriod()->end()->format('Y-m-d') }}
                        </div>
                    </div>
                    <div class="mt-2 ml-0 lg:ml-8 lg:mt-0 ">
                        {!! $sparkLine !!}
                    </div>
                </div>
            </div>
        </div>
@endcomponent
