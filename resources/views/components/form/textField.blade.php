<div>
    <div class="flex items-center justify-between mb-1">
        @isset($label)
            <label for="{{ $name }}" class="
            mr-2
            text-right
        ">
                {{ $label }}
            </label>
        @endisset

        <input
            id="{{ $name }}"
            type="{{ $type ?? 'text' }}"
            name="{{ $name }}"
            value="{{ old($name) ?? $initialValue ?? null }}"

            {{ ($required ?? null) ? 'required' : '' }}
            {{ ($autofocus ?? null) ? 'autofocus' : '' }}

            class="
                outline-none
                p-2
                rounded-sm
                bg-grey-lighter focus:bg-white
                focus:border-blue-light
                {{ $errors->has($name) ? 'border-red border' : 'border-transparent' }}
            "
        >
    </div>
    <div class="flex justify-end">
        @if ($errors->has($name))
            <span class="text-red">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>
</div>
