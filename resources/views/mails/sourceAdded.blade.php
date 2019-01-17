@component('mail::message')
A new source has been added and is waiting for [approval]({{ action([\App\Http\Controllers\AdminSourcesController::class, 'index']) }})

[{{ $source->url }}]({{ $source->url }}) ([{{ $source->website }}](http://{{ $source->website }})).
@endcomponent
