@php
$donationLink = 'https://www.patreon.com/brendt';
@endphp

<article class="py-8 border-b border-grey-lighter">
    <header class="text-xl font-bold font-title mb-4">
        <a href="{{ $donationLink }}" target="_blank" rel="noopener noreferrer" class="bg-yellow">
            {{ __('The shameless donation block') }}
        </a>
    </header>
    <section class="leading-normal">
        <p class="mb-2">
            {!! __("
                I'm not relying on ads to keep aggregate free.
                Bills have to be paid though.
                If you enjoy reading, or if this project helps your blog grow,
                I want to ask you to consider <a class=\"link\" href=\":donationLink\">donating through Patreon</a>.
            ", [
                'donationLink' => $donationLink,
            ]) !!}
        </p>

        <p>
            {{ __("
                Please only do so if you're freely able to and
                if donating doesn't affect your day-to-day life.
            ") }}
        </p>
    </section>
</article>
