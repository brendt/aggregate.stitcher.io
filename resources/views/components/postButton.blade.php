<form
    action="{{ $action }}"
    method="post"
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
