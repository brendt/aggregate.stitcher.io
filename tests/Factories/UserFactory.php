<?php

namespace Tests\Factories;

use App\Authentication\Role;
use App\Authentication\User;

final class UserFactory
{
    private string $name = 'test';
    private string $email = 'test@test.com';
    private ?Role $role = null;

    public static function new(): self
    {
        return new self();
    }

    public function withEmail(string $email): self
    {
        $clone = clone $this;

        $clone->email = $email;

        return $clone;
    }

    public function withName(string $name): self
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    public function withRole(Role $role): self
    {
        $clone = clone $this;

        $clone->role = $role;

        return $clone;
    }

    public function make(): User
    {
        return User::create(
            name: $this->name,
            email: $this->email,
            role: $this->role ?? Role::USER,
        );
    }
}