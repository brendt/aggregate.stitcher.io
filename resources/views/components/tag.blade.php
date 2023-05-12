@php
    $color = $attributes['color'] ?? 'gray';

    $class = $attributes['class'] . " bg-{$color}-100 rounded border border-{$color}-400 py-1 px-2 flex items-center";

    $style = $attributes['style'] ?? '';

    unset($attributes['style'], $attributes['class']);
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
