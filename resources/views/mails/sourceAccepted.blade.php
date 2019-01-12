@component('mail::message')
Hi there

Here's just a quick mail to let you know that your source, {{ $source->url }},
has been accepted on {{ config('app.name') }}.
Your content will now be automatically synced!

Kind regards<br>
Brent
@endcomponent
