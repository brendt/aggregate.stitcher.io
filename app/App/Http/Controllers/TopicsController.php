<?php

namespace App\Http\Controllers;

use App\Http\Queries\TopicIndexQuery;

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
