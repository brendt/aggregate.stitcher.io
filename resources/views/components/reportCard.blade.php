@php
    /** @var \Domain\Spam\Models\Spam $report */
@endphp


<article class="py-8 border-b border-grey-lighter">
    <header class="text-xl font-bold font-title mb-4">
        {{$report->user->name}}

    </header>
    <section class="leading-normal border-solid border-4 border-gray-600 p-2">
        <p class="mb-2">
            {{$report->report}}
        </p>
    </section>
</article>
