<canvas id="viewsChart" width="400" height="75"></canvas>

<script src="/js/chart.js"></script>
<script>
    new Chart(document.getElementById('viewsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($viewsPerDay->keys()) !!},
            datasets: [
                {
                    label: '{{ __('Views') }}',
                    data: {!! json_encode($viewsPerDay->values()) !!},
                    backgroundColor: 'rgba(135, 149, 161, .2)',
                    borderColor: 'rgba(135, 149, 161, .5)',
                    borderWidth: 2,
                },
                {
                    label: '{{ __('Votes') }}',
                    data: {!! json_encode($votesPerDay->values()) !!},
                    backgroundColor: 'rgba(252, 49, 73, .3 )',
                    borderColor: 'rgba(252, 49, 73, 1)',
                    borderWidth: 2,
                },
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
