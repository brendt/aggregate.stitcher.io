<div>
    <div class="sm:flex items-center justify-between mb-4 sm:mb-1 {{ $class ?? null }}">
        @isset($label)
            <label for="{{ $name }}" class="block w-full mb-1 sm:mb-0 mr-2">
                {{ $label }}
            </label>
        @endisset

        <textarea
            id="{{ $name }}"
            type="{{ $type ?? 'text' }}"
            name="{{ $name }}"

            {{ ($required ?? null) ? 'required' : '' }}
            {{ ($autofocus ?? null) ? 'autofocus' : '' }}

            class="block w-full outline-none p-2 rounded-sm bg-grey-lighter h-32"
        >{{ $value ?? old($name) ?? $initialValue ?? null }}</textarea>
    </div>
    <div class="flex justify-end">
        @if ($errors->has($name))
            <span class="text-red text-sm mb-2">
                {{ $errors->first($name) }}
            </span>
        @endif
    </div>
</div>
