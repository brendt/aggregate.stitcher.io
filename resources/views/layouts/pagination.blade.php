@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
@endphp

<nav style="margin-left: 2.375rem" class="py-4">
    @if($paginator->previousPageUrl())
        <a
            href="{{ $paginator->previousPageUrl() }}"
            rel="prev"
            class="text-sm px-3 py-1 border-red border text-red font-bold rounded mr-2"
            aria-label="@lang('pagination.previous')"
        >
            {{ __('Previous') }}
        </a>
    @endif

    @if($paginator->hasMorePages())
        <a
            href="{{ $paginator->nextPageUrl() }}"
            rel="prev"
            class="text-sm px-3 py-1 bg-red text-white font-bold rounded"
            aria-label="@lang('pagination.previous')"
        >
            {{ __('Next') }}
        </a>
    @endif
</nav>

