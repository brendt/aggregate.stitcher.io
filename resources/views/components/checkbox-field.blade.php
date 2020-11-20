<div class="flex items-center {{ $class ?? null }}">
    <input
        class=""
        type="checkbox"
        value="1"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ (old($name) ?? $initialValue ?? null) ? 'checked' : '' }}
    >

    <label class="ml-2" style="margin-top: 0.3rem" for="{{ $name }}">
        {{ $label }}
    </label>
</div>
