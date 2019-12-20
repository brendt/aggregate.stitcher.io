<?php

namespace App\Mail;

use App\User\Controllers\UserVerificationController;
use Domain\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyUserMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /** @var \Domain\User\Models\User */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->to($this->user->email)
            ->subject(__("Verify your :app_name account", ['app_name' => config('app.name')]))
            ->markdown('mails.verifyUser', [
                'user' => $this->user,
                'verificationUrl' => action([UserVerificationController::class, 'verify'], [
                    $this->user->verification_token,
                ]),
            ]);
    }
}
