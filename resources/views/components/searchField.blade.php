<form
    action="{{ $currentUrl }}"
    method="GET"
    class="md:flex mt-4"
>
    <div class="md:hidden">
        <label for="filter[search]">{{ __('Search:') }}</label>
    </div>

    <text-field
        name="filter[search]"
        label=""
        :value="$currentSearchQuery"
    ></text-field>

    <div>
        <submit-button class="md:ml-4 button-small">
            {{ __('Search') }}
        </submit-button>

        @if($currentSearchQuery)
            <a href="{{ $currentUrl }}" class="ml-2 link">
                {{ __('Clear search') }}
            </a>
        @endif
    </div>
</form>
