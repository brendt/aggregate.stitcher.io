<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class AllSourcesSeeder extends Seeder
{
    public function run()
    {
        $urls = explode(PHP_EOL, file_get_contents(__DIR__ . '/sources.txt'));

        foreach ($urls as $url) {
            $name = parse_url($url, PHP_URL_HOST);

            if (! $name) {
                continue;
            }

            Source::create([
                'name' => $name,
                'url' => $url,
            ]);
        }
    }
}
