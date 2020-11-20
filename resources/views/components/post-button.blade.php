<form
        action="{{ $action }}"
        method="{{ $method?? "post" }}"
        @if(isset($inline) && $inline) class="inline-block" @endif
>
    @csrf

    <button
            type="submit"
            class="{{ $class ?? '' }}"
            style="{{ $style ?? null }}"
    >
        {{ $slot }}
    </button>
</form>
