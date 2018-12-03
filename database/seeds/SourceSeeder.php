<?php

use Domain\Source\Models\Source;
use Domain\User\Models\User;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    public function run()
    {
        collect([
            'https://stitcher.io/rss',
        ])->each(function (string $url) {
            Source::create([
                'url' => $url,
                'user_id' => User::first()->id,
            ]);
        });
    }
}
