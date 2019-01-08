<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Domain\Post\Models\Tag;

$factory->define(Tag::class, function () {
    return [
        'name' => 'test',
        'color' => '#fff',
        'keywords' => ['test'],
    ];
});
