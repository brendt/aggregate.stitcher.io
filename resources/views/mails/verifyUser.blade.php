@component('mail::message')
# Welcome!

Thanks for joining {{ config('app.name') }}!
We're happy to welcome you and your content on our platform.

Before submitting your RSS feed, you'll have to verify your account.

@component('mail::button', ['url' => $verificationUrl])
Verify your account
@endcomponent

Kind regards<br>
Brent
@endcomponent
