@component('mail::message')
A new source has been added and is waiting for [approval]({{ action([\App\Admin\Controllers\AdminSourcesController::class, 'index']) }})

[{{ $source->url }}]({{ $source->url }}) ([{{ $source->website }}](http://{{ $source->website }})).
@endcomponent
