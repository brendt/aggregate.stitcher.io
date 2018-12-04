<?php

use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create([
            'name' => 'BrenDt',
            'email' => 'brent@spatie.be',
        ]);

        factory(User::class, 20)->create();
    }
}
