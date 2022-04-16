@component('mail::message')
    # A new source was added

    @component('mail::button', ['url' => action(\App\Http\Controllers\Sources\AdminSourcesController::class)])
        View Source
    @endcomponent

@endcomponent
