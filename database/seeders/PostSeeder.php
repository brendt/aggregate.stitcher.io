<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostState;
use App\Models\PostVisit;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::factory()->count(5)->create([
            'state' => PostState::PUBLISHED,
        ]);

        foreach ($posts as $post) {
            $date = now()->subDays(10);

            while ($date < now()) {
                foreach (range(1, rand(1, 75)) as $visit) {
                    PostVisit::create([
                        'post_id' => $post->id,
                        'created_at' => $date,
                        'created_at_day' => $date,
                    ]);
                }

                $date->addDay();
            }
        }
    }
}
