@php
    /** @var \Domain\Spam\Models\Spam[] $reports */

@endphp

<section>
    @foreach($reports as $report)
        <report-card
                :report="$report"
        ></report-card>
    @endforeach
</section>

