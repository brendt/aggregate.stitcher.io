<?php

use Domain\Post\Actions\AddViewAction;
use Domain\Post\Actions\AddVoteAction;
use Domain\Post\Models\Post;
use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $sources = Source::all();
        $users = User::all();

        $addVoteAction = app(AddVoteAction::class);
        $addViewAction = app(AddViewAction::class);

        foreach ($sources as $source) {
            foreach (range(1, 3) as $i) {
                $post = Post::create([
                    'source_id' => $source->id,
                    'url' => '/#',
                    'title' => faker()->words(faker()->numberBetween(1, 4), true),
                    'date_created' => now()->subDays(faker()->numberBetween(0, 1000)),
                ]);

                foreach ($users as $user) {
                    if (faker()->boolean(35)) {
                        $addVoteAction->execute($post, $user);
                    }

                    foreach (range(0, faker()->numberBetween(0, 5)) as $i) {
                        $addViewAction->execute($post, $user);
                    }
                }
            }
        }
    }
}
