<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\Post\Models\PostTag;

$factory->define(PostTag::class, function () {
    return [
        'id' => faker()->randomNumber(),
        'post_id' => faker()->randomNumber(),
        'tag_id' => faker()->randomNumber(),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
