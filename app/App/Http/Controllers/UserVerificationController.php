<?php

namespace App\Http\Controllers;

use Domain\User\Events\ResendVerificationEvent;
use Domain\User\Events\VerifyUserEvent;
use Domain\User\Models\User;
use Illuminate\Http\Response;

class UserVerificationController
{
    public function verify(User $user, string $verificationToken)
    {
        abort_unless($user->verification_token === $verificationToken, Response::HTTP_NOT_FOUND);

        event(new VerifyUserEvent($user->uuid, $verificationToken));

        return redirect()->action([UserSourcesController::class, 'index']);
    }

    public function resend(User $user)
    {
        event(new ResendVerificationEvent($user->uuid));

        return redirect()->back();
    }
}
