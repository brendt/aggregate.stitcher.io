<?php

use App\Domain\Post\DTO\PostData;
use App\Domain\Post\Events\AddViewEvent;
use App\Domain\Post\Events\AddVoteEvent;
use Domain\Post\Actions\AddViewAction;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Events\CreatePostEvent;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /** @var \Domain\User\Models\User[]|\Illuminate\Database\Eloquent\Collection */
    private $users;

    public function __construct()
    {
        $this->users = User::all();
    }

    public function run()
    {
        foreach (Source::all() as $source) {
            $this->createPosts($source);
        }
    }

    private function createPosts(Source $source): void
    {
        $postData = new PostData([
            'url' => '/#',
            'title' => faker()->words(faker()->numberBetween(1, 4), true),
            'date_created' => now()->subDays(faker()->numberBetween(0, 1000)),
            'teaser' => '',
        ]);

        event(CreatePostEvent::new($source, $postData));

        $post = Post::whereUuid($postData->uuid)->firstOrFail();

        $this->addViewsAndVotes($post);
    }

    private function addViewsAndVotes(Post $post): void
    {
        foreach ($this->users as $user) {
            if (faker()->boolean(35)) {
                event(AddVoteEvent::create($post, $user));
            }

            if (faker()->boolean(60)) {
                event(AddViewEvent::create($post, $user));
            }
        }
    }
}
