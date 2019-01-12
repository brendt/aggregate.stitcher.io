<?php

use Domain\User\Events\CreateUserEvent;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        event(CreateUserEvent::create('brent@stitcher.io', bcrypt('secret')));

        $user = User::whereEmail('brent@stitcher.io')->first();

        $user->is_admin = true;
        $user->is_verified = true;

        $user->save();
    }
}
