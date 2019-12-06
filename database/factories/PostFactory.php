<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\Post\Models\Post;
use Domain\Source\Models\Source;

$factory->define(Post::class, function () {
    return [
        'uuid' => faker()->uuid,
        'source_id' => function () {
            return factory(Source::class)->create()->id;
        },
        'url' => faker()->url,
        'title' => faker()->title,
        'date_created' => now(),
        'is_validated' => true,
        'teaser' => faker()->randomElement(
            [faker()->text(), '']
        ),
    ];
});
