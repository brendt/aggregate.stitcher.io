<form
    action="{{ $action }}"
    method="post"
>
    @csrf

    <button
        type="submit"
        class="ajax-button {{ $class ?? '' }}"
        id="{{ $id ?? '' }}"
        data-done="{{ $dataDone ?? '() => {};' }}"
    >
        {{ $slot }}
    </button>
</form>
