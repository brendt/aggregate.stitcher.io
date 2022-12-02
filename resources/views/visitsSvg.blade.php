<svg width="155" height="30">
    <defs>
        <linearGradient id="gradient-{{ $post->id }}" x1="0" x2="0" y1="1" y2="0">
            <stop offset="0%" stop-color="#C82161"></stop>
            <stop offset="10%" stop-color="#fe2977"></stop>
            <stop offset="25%" stop-color="#b848f5"></stop>
            <stop offset="50%" stop-color="#b848f5"></stop>
        </linearGradient>
        <mask id="sparkline-{{ $post->id }}" x="0" y="0" width="155" height="28">
            <polyline transform="translate(0, 28) scale(1,-1)" points="{{ $coordinates }}" fill="transparent" stroke="#8cc665" stroke-width="2">
            </polyline></mask>
    </defs>

    <g transform="translate(0, -3)">
        <rect x="0" y="-2" width="155" height="30" style="stroke: none; fill: url(#gradient-{{ $post->id }}); mask: url(#sparkline-{{ $post->id }})"></rect>
    </g>
</svg>
