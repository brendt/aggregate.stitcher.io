@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
@endphp

<nav class="text-sm text-grey-darker leading-normal pt-2 flex items-center justify-between w-full">
    <div>
        @if($paginator->previousPageUrl())
            <a
                href="{{ $paginator->previousPageUrl() }}"
                rel="prev"
                aria-label="Newer"
            >
                {{ __('Newer') }}
            </a>
        @endif
    </div>

    <div>
        @if($paginator->hasMorePages())
            <a
                href="{{ $paginator->nextPageUrl() }}"
                rel="prev"
                aria-label="More"
            >
                {{ __('More') }}
            </a>
        @endif
    </div>
</nav>

