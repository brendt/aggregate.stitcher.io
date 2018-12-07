<form
    action="{{ $action }}"
    method="post"
>
    @csrf

    <button
        type="submit"
        class="ajax-button {{ $class ?? '' }}"
        data-done="{{ $dataDone ?? '() => {};' }}"
    >
        {{ $slot }}
    </button>
</form>
