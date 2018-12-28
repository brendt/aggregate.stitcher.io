<form
    action="{{ $action }}"
    method="post"
>
    @csrf

    <button
        type="submit"
        class="ajax-button {{ $class ?? '' }}"
        style="{{ $style ?? null }}"
        data-done="{{ $dataDone ?? '() => {};' }}"
    >
        {{ $slot }}
    </button>
</form>
