<?php

use App\Domain\User\Events\CreateUserEvent;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        event(new CreateUserEvent('brent@spatie.be', bcrypt('secret')));
    }
}
