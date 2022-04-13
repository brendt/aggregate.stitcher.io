<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    public function run()
    {
        Source::create([
            'name' => 'stitcher.io',
            'url' => 'https://stitcher.io/rss',
        ]);
    }
}
