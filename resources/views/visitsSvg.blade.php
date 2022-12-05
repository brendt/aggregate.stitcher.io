<svg width="155" height="30">
    <defs>
        <linearGradient id="gradient-{{ $id }}" x1="0" x2="0" y1="1" y2="0">
            @foreach($colors as $percentage => $color)
            <stop offset="{{ $percentage }}%" stop-color="{{ $color }}"></stop>
            @endforeach
        </linearGradient>
        <mask id="sparkline-{{ $id }}" x="0" y="0" width="155" height="28">
            <polyline transform="translate(0, 28) scale(1,-1)" points="{{ $coordinates }}" fill="transparent" stroke="#8cc665" stroke-width="2">
            </polyline></mask>
    </defs>

    <g transform="translate(0, -3)">
        <rect x="0" y="-2" width="155" height="30" style="stroke: none; fill: url(#gradient-{{ $id }}); mask: url(#sparkline-{{ $id }})"></rect>
    </g>
</svg>
