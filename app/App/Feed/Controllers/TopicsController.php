<?php

namespace App\Feed\Controllers;

use App\Feed\Queries\TopicIndexQuery;

final class TopicsController
{
    public function index(TopicIndexQuery $query)
    {
        $topics = $query->get();

        return view('topics.index', [
            'topics' => $topics,
        ]);
    }
}
