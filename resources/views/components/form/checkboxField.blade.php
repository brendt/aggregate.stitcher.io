<div class="{{ $class ?? null }}">
    <input
        class=""
        type="checkbox"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ old($name) ? 'checked' : '' }}
    >

    <label class="" for="{{ $name }}">
        {{ $label }}
    </label>
</div>
