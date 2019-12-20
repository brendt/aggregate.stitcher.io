<?php

use App\Feed\Controllers\RssController;

return [
    'feeds' => [
        'main' => [
            'items' => [
                RssController::class . '@feed',
            ],
            'url' => '/rss',
            'title' => 'aggregate.stitcher.io',
            'view' => 'feed::feed',
        ],
    ],
];
