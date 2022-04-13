<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        (new UserSeeder)->run();
        (new SourceSeeder)->run();
        (new PostSeeder)->run();
    }
}
