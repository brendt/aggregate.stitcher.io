<div class="{{ $class ?? null }}">
    @isset($label)
        <div class="mb-2 mt-2">{{ $label }}</div>
    @endisset

    @foreach ($options as $key => $optionLabel)
        <div class="w-1/2">
            <input
                class=""
                type="checkbox"
                name="{{ $name }}"
                value="{{ $key }}"
                id="{{ $name }}-{{ $key }}"
                {{ ($initialValues[$key] ?? null) ? 'checked' : '' }}
            >

            <label class="ml-2" style="margin-top: 0.3rem" for="{{ $name }}-{{ $key }}">
                {{ $optionLabel }}
            </label>
        </div>
    @endforeach
</div>
