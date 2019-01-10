<?php

namespace App\Http\Queries;

use Domain\Post\Models\Topic;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TopicIndexQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Topic::query();

        parent::__construct($query, $request);
    }
}
