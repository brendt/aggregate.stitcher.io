<?php

namespace Domain\User\Actions;

use App\Mail\VerifyUserMail;
use Domain\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

final class SendUserVerificationAction
{
    public function __invoke(User $user): void
    {
        $user->verification_token = $this->generateVerificationToken($user->email);

        $user->save();

        Mail::queue(new VerifyUserMail($user));
    }

    public function generateVerificationToken(string $email): string
    {
        return sha1(Hash::make($email . (string) Uuid::uuid4()));
    }
}
