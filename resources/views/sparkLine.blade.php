<svg width="{{ $width }}" height="{{ $height }}">
    <defs>
        <linearGradient id="gradient-{{ $id }}" x1="0" x2="0" y1="1" y2="0">
            @foreach($colors as $percentage => $color)
                <stop offset="{{ $percentage }}%" stop-color="{{ $color }}"></stop>
            @endforeach
        </linearGradient>
        <mask id="sparkline-{{ $id }}" x="0" y="0" width="{{ $width }}" height="{{ $height - 2 }}">
            <polyline
                transform="translate(0, {{ $height - 2 }}) scale(1,-1)"
                points="{{ $coordinates }}"
                fill="transparent"
                stroke="{{ $colors[0] }}"
                stroke-width="{{ $strokeWidth }}"
            >
            </polyline>
        </mask>
    </defs>

    <g transform="translate(0, 0)">
        <rect x="0" y="0" width="{{ $width }}" height="{{ $height }}" style="stroke: none; fill: url(#gradient-{{ $id }}); mask: url(#sparkline-{{ $id }})"></rect>
    </g>
</svg>
