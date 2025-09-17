<?php

namespace App\Authentication;

use Tempest\Auth\Authentication\Authenticatable;
use Tempest\Database\Hashed;
use Tempest\Database\IsDatabaseModel;
use Tempest\Database\Virtual;

final class User implements Authenticatable
{
    use IsDatabaseModel;

    public function __construct(
        public string $name,
        public string $email,
        #[Hashed]
        public ?string $password,
        public Role $role = Role::USER,
    ) {}

    #[Virtual]
    public bool $isAdmin {
        get => $this->role === Role::ADMIN;
    }
}
