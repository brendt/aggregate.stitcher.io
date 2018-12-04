<?php

use Domain\Post\Actions\AddViewAction;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /** @var \Domain\User\Models\User[]|\Illuminate\Database\Eloquent\Collection */
    private $users;

    /** @var \Domain\Post\Actions\AddVoteAction|\Illuminate\Foundation\Application|mixed */
    private $addVoteAction;

    /** @var \Domain\Post\Actions\AddViewAction|\Illuminate\Foundation\Application|mixed */
    private $addViewAction;

    public function __construct()
    {
        $this->users = User::all();

        $this->addVoteAction = app(AddVoteAction::class);
        $this->addViewAction = app(AddViewAction::class);
    }

    public function run()
    {
        foreach (Source::all() as $source) {
            $this->createPosts($source);
        }
    }

    private function createPosts(Source $source): void
    {
        $post = Post::create([
            'source_id' => $source->id,
            'url' => '/#',
            'title' => faker()->words(faker()->numberBetween(1, 4), true),
            'date_created' => now()->subDays(faker()->numberBetween(0, 1000)),
        ]);

        $this->addViewsAndVotes($post);
    }

    private function addViewsAndVotes(Post $post): void
    {
        foreach ($this->users as $user) {
            if (faker()->boolean(35)) {
                $this->addVoteAction->execute($post, $user);
            }

            foreach (range(0, faker()->numberBetween(0, 5)) as $i) {
                $this->addViewAction->execute($post, $user);
            }
        }
    }
}
