@php
    $color = $attributes['color'] ?? 'gray';
    $textColor = $attributes['text-color'] ?? null;
    $borderColor = $attributes['border-color'] ?? null;
    $style = $attributes['style'] ?? '';
    $class = $attributes['class'] . " rounded border py-1 px-2 flex items-center";

    if (str_starts_with($color, '#')) {
        $style .= " background-color: {$color};";
    } else {
        $class .= " bg-{$color}-100 border-{$color}-400";
    }

    if ($textColor) {
        $style .= " color: {$textColor};";
    }

    if ($borderColor) {
        $style .= " border-color: {$borderColor};";
    }

    unset($attributes['style'], $attributes['class'], $attributes['text-color']);
@endphp

<span>
    @isset($url)
        <a {{ $attributes }} class="{{ $class }} hover:bg-{{ $color }}-200 hover:border-{{ $color }}-300" href="{{ $url }}" style="{{ $style }}">
            {{ $slot }}
        </a>
    @else
        <div {{ $attributes }} class="{{ $class }} cursor-default" style="{{ $style }}">
            {{ $slot }}
        </div>
    @endisset
</span>
