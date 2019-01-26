<div class="flex items-center {{ $class ?? null }}">
    <input
        class=""
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ old($name) ? 'checked' : '' }}
    >

    <label class="ml-2" style="margin-top: 0.3rem" for="{{ $name }}">
        {{ $label }}
    </label>
</div>
