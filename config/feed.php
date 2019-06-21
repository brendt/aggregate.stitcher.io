<?php

use App\Http\Queries\AllPostsQuery;

return [
    'feeds' => [
        'main' => [
            'items' => [
                vsprintf('%s@%s', [AllPostsQuery::class, 'get'])
            ],
            'url' => '/rss',
            'title' => 'aggregate.stitcher.io',
            'view' => 'feed::feed',
        ],
    ],
];
