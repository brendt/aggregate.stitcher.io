@php
$firstDataSet = $viewsPerDay ?? $votesPerDay ?? collect();

$labels = $firstDataSet->keys();

$id = \Ramsey\Uuid\Uuid::uuid4();
@endphp

<canvas id="viewsChart-{{ $id }}" width="{{ $with ?? 400 }}" height="{{ $height ?? 75 }}"></canvas>

<script src="/js/chart.js"></script>
<script>
    new Chart(document.getElementById('viewsChart-{{ $id }}'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                @isset($viewsPerDay)
                    {
                        label: '{{ __('Views') }}',
                        data: {!! json_encode($viewsPerDay->values()) !!},
                        backgroundColor: 'rgba(135, 149, 161, .2)',
                        borderColor: 'rgba(135, 149, 161, .5)',
                        borderWidth: 2,
                    },
                @endisset
                @isset($votesPerDay)
                    {
                        label: '{{ __('Votes') }}',
                        data: {!! json_encode($votesPerDay->values()) !!},
                        backgroundColor: 'rgba(252, 49, 73, .3 )',
                        borderColor: 'rgba(252, 49, 73, 1)',
                        borderWidth: 2,
                    },
                @endisset
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
