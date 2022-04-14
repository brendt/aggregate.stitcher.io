<?php

namespace Database\Seeders;

use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    public function run()
    {
        Source::create([
            'name' => 'stitcher.io',
            'url' => 'https://stitcher.io/rss',
            'state' => SourceState::PUBLISHED,
        ]);

        Source::create([
            'name' => 'publishing source',
            'url' => 'https://stitcher.io',
            'state' => SourceState::PUBLISHING,
        ]);

        Source::create([
            'name' => 'pending source',
            'url' => 'https://stitcher.io/rss',
            'state' => SourceState::PENDING,
        ]);

        Source::create([
            'name' => 'denied source',
            'url' => 'https://stitcher.io/rss',
            'state' => SourceState::DENIED,
        ]);
    }
}
