<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'email' => 'brendt@stitcher.io',
            'name' => 'Brent',
            'password' => bcrypt('password'),
        ]);
    }
}
