<?php

use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'BrenDt',
            'email' => 'brent@spatie.be',
            'password' => bcrypt('secret'),
        ]);
    }
}
