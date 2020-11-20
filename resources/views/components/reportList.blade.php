@php
    /** @var \Domain\PostReport\Models\PostReport[] $reports */

@endphp

<section>
    @foreach($reports as $report)
        <report-card
                :report="$report"
        ></report-card>
    @endforeach
</section>

