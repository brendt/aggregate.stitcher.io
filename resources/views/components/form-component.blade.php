<form
    method="{{ $method ?? 'post' }}"
    action="{{ $action }}"
    class="{{ $class ?? null }}"
>
    @csrf

    {{ $slot ?? null }}
</form>
