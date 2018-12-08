<?php

use Domain\Post\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'php' => [
                'keywords' => [
                    'php', 'laravel', 'symfony', 'yii',
                ],
                'color' => '#8791c2',
            ],
            'javascript' => [
                'keywords' => [
                    'javascript', 'vuejs', 'vue', 'reactjs',
                ],
                'color' => '#f3dc20',
            ],
            'css' => [
                'keywords' => [
                    'css', 'tailwind', 'sccs', 'postcss', 'sass',
                ],
                'color' => '#006eb6',
            ],
            'design' => [
                'keywords' => [
                    'design'
                ],
                'color' => '#68CC14',
            ],
            'writing' => [
                'keywords' => [
                    'content', 'blog',
                ],
                'color' => '#CC146B',
            ]
            // #19E0FF
        ];

        foreach ($tags as $name => $data) {
            Tag::create([
                'name' => $name,
                'keywords' => $data['keywords'],
                'color' => $data['color'],
            ]);
        }
    }
}
