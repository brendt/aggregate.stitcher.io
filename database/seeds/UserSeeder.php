<?php

use Domain\User\Events\CreateUserEvent;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        event(CreateUserEvent::create('brent@spatie.be', bcrypt('secret')));
    }
}
