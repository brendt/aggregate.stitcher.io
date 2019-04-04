@php
$dataSet = $data instanceof \Illuminate\Support\Collection
    ? $data
    : collect($data);

$labels = $dataSet->keys();

$id = \Ramsey\Uuid\Uuid::uuid4();
@endphp

<canvas id="viewsChart-{{ $id }}" width="{{ $width ?? 400 }}" height="{{ $height ?? 75 }}"></canvas>

<script src="/js/chart.js"></script>
<script>
    new Chart(document.getElementById('viewsChart-{{ $id }}'), {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: '{{ $label ?? '' }}',
                    data: {!! json_encode($dataSet->values()) !!},
                    backgroundColor: '{{ $backgroundColor ?? 'rgba(135, 149, 161, .2)' }}',
                    borderColor: '{{ $borderColor ?? 'rgba(135, 149, 161, .5)' }}',
                    borderWidth: 2,
                }
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
