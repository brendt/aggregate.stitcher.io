<?php

use Domain\Post\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {


        foreach ($tags as $name => $data) {
            Tag::create([
                'name' => $name,
                'keywords' => $data['keywords'],
                'color' => $data['color'],
            ]);
        }
    }
}
