<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Rule;

class EmailMatchesRule implements Rule
{
    public function __construct(private string $expected) {}

    public function passes($attribute, $value): bool
    {
        return $value === $this->expected;
    }

    public function message(): string
    {
        return "The email address doesn't match this invitation.";
    }
}
