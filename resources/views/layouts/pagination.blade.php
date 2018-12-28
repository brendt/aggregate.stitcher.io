@if($paginator->hasMorePages())
    <nav class="py-4" style="margin-left: 2.375rem">
        <a
            href="{{ $paginator->nextPageUrl() }}"
            rel="prev"
            class="text-sm px-3 py-1 bg-red text-white font-bold rounded"
            aria-label="@lang('pagination.previous')"
        >
            More
        </a>
    </nav>
@endif
