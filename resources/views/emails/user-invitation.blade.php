@component('mail::message')
# Hi there!

This is a quick email to let you know that {{ $user->invitedBy->name }} has invited you to join [aggregate.stitcher.io](https://aggregate.stitcher.io)! If you wish to accept this invitation, simply press the button below, choose a username and password, and you're set!

@component('mail::button', ['url' => action(\App\Http\Controllers\Users\AcceptInvitationController::class, ['code' => $user->invitation_code])])
Accept invitation
@endcomponent

Thanks<br>
Brent
@endcomponent
