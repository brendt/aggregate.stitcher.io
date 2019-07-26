<?php

namespace Domain\User\Actions;

use App\Mail\VerifyUserMail;
use Domain\User\Models\User;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

final class SendUserVerificationAction
{
    /** @var \Illuminate\Mail\Mailer */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(User $user): void
    {
        $user->verification_token = $this->generateVerificationToken($user->email);

        $user->save();

        $this->sendVerification($user);
    }

    public function generateVerificationToken(string $email): string
    {
        return sha1(Hash::make($email . (string) Uuid::uuid4()));
    }

    private function sendVerification(User $user): void
    {
        $mail = new VerifyUserMail($user);

        $this->mailer->send($mail);
    }
}
