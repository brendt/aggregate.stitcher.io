@php
$donationLink = 'https://www.patreon.com/brendt';
@endphp

<article class="p-8 -mx-4 -mt-px bg-yellow">
    <header class="text-xl font-bold font-title mb-2">
        <a href="{{ $donationLink }}" target="_blank" rel="noopener noreferrer">
            {{ __('The shameless donation block') }}
        </a>
    </header>
    <section class="leading-normal">
        <p>
            {{ __("
                We're not relying on ads to keep aggregate.stitcher.io free.
                Bills need to be paid though.
                If you enjoy reading, or if this project helps your blog grow,
                we want to ask you to consider donating.
            ") }}
        </p>

        <p>
            {{ __("
                Please only do so if you're freely able to and
                if donating doesn't affect your day-to-day life.
            ") }}
        </p>

        <p class="mt-2">
            <a
                href="{{ $donationLink }}"
                class="link"
            >
                {{ __('Donate via Patreon') }}
            </a>
        </p>
    </section>
</article>
