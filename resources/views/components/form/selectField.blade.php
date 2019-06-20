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

        <select
                id="{{ $name }}"
                name="{{ $name }}"
                value="{{ $value ?? old($name) ?? $initialValue ?? null }}"

                {{ ($required ?? null) ? 'required' : '' }}
                {{ ($autofocus ?? null) ? 'autofocus' : '' }}

                class="outline-none p-2 rounded-sm bg-grey-lighter w-100"
        >
            <option value></option>
            {{ $slot }}
        </select>
    </div>
    <div class="flex justify-end">
        @if ($errors->has($name))
            <span class="text-red text-sm mb-2">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>
</div>
