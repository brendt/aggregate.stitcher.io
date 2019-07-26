<form
    action="{{ $action }}"
    method="post"
    class="{{ $formClass ?? null }}"
>
    @csrf

    <button
        type="submit"
        class="ajax-button {{ $class ?? '' }}"
        style="{{ $style ?? null }}"
        data-done="{!! $dataDone ?? '() => {};' !!}"
        @isset($title)
            title="{{ $title }}"
        @endisset
    >
        {{ $slot }}
    </button>
</form>
