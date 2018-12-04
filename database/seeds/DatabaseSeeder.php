<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(SourceSeeder::class);
         $this->call(PostSeeder::class);
    }
}
