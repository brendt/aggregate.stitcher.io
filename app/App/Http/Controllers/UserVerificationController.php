<?php

namespace App\Http\Controllers;

use Domain\User\Actions\SendUserVerificationAction;
use Domain\User\Actions\VerifyUserAction;
use Domain\User\Models\User;
use Illuminate\Http\Response;

class UserVerificationController
{
    public function verify(
        User $user,
        string $verificationToken,
        VerifyUserAction $verifyUserAction
    ) {
        abort_unless($user->verification_token === $verificationToken, Response::HTTP_NOT_FOUND);

        $verifyUserAction($user);

        return redirect()->action([UserSourcesController::class, 'index']);
    }

    public function resend(
        User $user,
        SendUserVerificationAction $sendUserVerificationAction
    ) {
        $sendUserVerificationAction($user);

        return redirect()->back();
    }
}
