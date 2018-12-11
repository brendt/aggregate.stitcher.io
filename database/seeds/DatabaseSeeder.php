<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** @var bool */
    private $withPosts = false;

    public function withPosts(bool $withPosts): DatabaseSeeder
    {
        $this->withPosts = $withPosts;

        return $this;
    }

    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(SourceSeeder::class);

        if ($this->withPosts) {
            $this->call(PostSeeder::class);
        }
    }
}
