@php
$donationLink = 'https://www.patreon.com/brendt';
@endphp

<div class="w-full flex py-6">
    <div class="mr-6 flex items-center">
        <heart-icon color="var(--green)"/>
    </div>

    <div class="flex-1">
        <p class="mb-2">
            <a
                class="text-xl font-bold font-title"
                href="{{ $donationLink }}"
                target="_blank" rel="noopener noreferrer"
            >
                {{ __('The shameless donation block') }}
            </a>
        </p>

        <p class="text-grey-dark leading-normal">
            {{ __("
                We're not relying on ads to keep aggregate.stitcher.io free.
                Bills need to be paid though.
                If you enjoy reading, or if this project helps your blog grow,
                we want to ask you to consider donating.
            ") }}
        </p>

        <p class="text-grey-dark leading-normal">
            {{ __("
               Please only do so if you're freely able to and
               if donating doesn't affect your day-to-day life.
            ") }}
        </p>

        <p class="mt-2 leading-normal text-grey-dark">
            <a
                href="{{ $donationLink }}"
                class="link"
            >
                {{ __('Donate via Patreon') }}
            </a>
        </p>
    </div>
</div>
