<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;

final class CreateUserAction
{
    /** @var \Domain\User\Actions\SendUserVerificationAction */
    private $sendUserVerificationAction;

    public function __construct(SendUserVerificationAction $sendUserVerificationAction)
    {
        $this->sendUserVerificationAction = $sendUserVerificationAction;
    }

    public function __invoke(string $email, string $password_hash): User
    {
        $user = User::create([
            'name' => $email,
            'email' => $email,
            'password' => $password_hash,
            'verification_token' => $this->sendUserVerificationAction
                ->generateVerificationToken($email),
        ]);

        ($this->sendUserVerificationAction)->__invoke($user);

        return $user;
    }
}
