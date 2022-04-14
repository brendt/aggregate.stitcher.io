<?php

namespace Database\Seeders;

use App\Models\Source;
use App\Models\SourceState;
use Illuminate\Database\Seeder;
use Throwable;

class AllSourcesSeeder extends Seeder
{
    public function run()
    {
        (new UserSeeder)->run();

        $urls = explode(PHP_EOL, file_get_contents(__DIR__ . '/sources.txt'));

        foreach ($urls as $url) {
            if (! $url) {
                continue;
            }

            Source::create([
                'url' => $url,
                'state' => SourceState::PUBLISHED,
            ]);
        }
    }
}
