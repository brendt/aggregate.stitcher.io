<form
    action="{{ $currentUrl }}"
    method="GET"
    class="flex mt-4"
>
    <text-field
        name="filter[search]"
        label=""
        :value="$currentSearchQuery"
    ></text-field>

    <submit-button class="ml-4 button-small">
        {{ __('Search') }}
    </submit-button>

    @if($currentSearchQuery)
        <div class="ml-4 pt-2">
            <a href="{{ $currentUrl }}" class="link">
                {{ __('Clear search') }}
            </a>
        </div>
    @endif
</form>
