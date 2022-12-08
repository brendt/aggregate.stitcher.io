<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\LinkVisit;
use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    public function run()
    {
        $link = Link::create([
            'url' => 'https://stitcher.io',
            'visits' => 0,
        ]);

        $date = now()->subDays(10);

        while ($date < now()) {
            foreach (range(1, rand(1, 75)) as $visit) {
                LinkVisit::create([
                    'link_id' => $link->id,
                    'created_at' => $date,
                    'created_at_day' => $date,
                ]);
            }

            $date->addDay();
        }
    }
}
