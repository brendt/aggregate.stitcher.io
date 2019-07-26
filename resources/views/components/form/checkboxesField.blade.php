<div class="{{ $class ?? null }} sm:flex items-center justify-between mb-4 sm:mb-1">
    @isset($label)
        <div class="mb-2 mt-2">{{ $label }}</div>
    @endisset

    <div class="md:flex md:flex-wrap md:justify-end md:w-3/5">
        @foreach ($options as $key => $optionLabel)
            <div class="md:w-2/5 {{ $itemClass ?? null }}">
                <input
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
</div>
