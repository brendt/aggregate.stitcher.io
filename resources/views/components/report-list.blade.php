@php
    /** @var \Domain\PostReport\Models\PostReport[] $reports */

@endphp

<section>
    @foreach($reports as $report)
        <x-report-card
                :report="$report"
        ></x-report-card>
    @endforeach
</section>

