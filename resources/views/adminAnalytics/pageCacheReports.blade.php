@php
    /** @var \Domain\Analytics\Models\PageCacheReport[] $pageCacheReports */
@endphp

@component('layouts.admin', [
    'title' => __('Analytics'),
])
    <x-heading>{{ __('Analytics: page cache') }}</x-heading>

    <canvas id="page-cache-report-chart" width="{{ $width ?? 400 }}" height="{{ $height ?? 75 }}"></canvas>

    <script src="/js/chart.js"></script>
    <script>
        new Chart(document.getElementById('page-cache-report-chart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($days)  !!},
                datasets: [
                    {
                        label: 'Misses',
                        data: {!! json_encode($misses) !!},
                        backgroundColor: 'rgba(220, 10, 0, .5)',
                        borderColor: 'rgba(200, 10, 0, 1)',
                        borderWidth: 2,
                    },
                    {
                        label: 'Hits',
                        data: {!! json_encode($hits) !!} ,
                        backgroundColor: 'rgba(0, 200, 10, .5)',
                        borderColor: 'rgba(0, 180, 0, 1)',
                        borderWidth: 2,
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endcomponent
