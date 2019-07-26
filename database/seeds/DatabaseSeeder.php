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

    public function run(): void
    {
        throw new RuntimeException("Cannot run seeders this way, please use `artisan playbook:run {playbook} {--clean}`");
    }
}
