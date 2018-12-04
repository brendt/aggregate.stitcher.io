@php
    /** @var \Domain\Source\Models\Source $source */
@endphp

@component('layouts.app', [
    'title' => __('Sources'),
])
    <form
        action="{{ action([\App\Http\Controllers\SourcesController::class, 'update']) }}"
        method="post"
    >
        @csrf

        <label for="url">{{ __('URL') }}</label>
        <input id="url" type="text" name="url" value="{{ $source->url }}">

        @if ($errors->has('url'))
            <strong>{{ $errors->first('url') }}</strong>
        @endif

        <button>
            {{ __('Save') }}
        </button>
    </form>

    <form
        action="{{ action([\App\Http\Controllers\SourcesController::class, 'delete']) }}"
        method="post"
    >
        @csrf

        <button>
            {{ __('Delete source') }}
        </button>
    </form>
@endcomponent
