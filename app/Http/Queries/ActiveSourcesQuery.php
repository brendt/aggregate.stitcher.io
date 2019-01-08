<?php

namespace App\Http\Queries;

use Domain\Source\Models\Source;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ActiveSourcesQuery extends QueryBuilder
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Post $query
     * @var \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $query = Source::query()->whereActive();

        $user = $request->user();

        if ($user) {
            $query->whereNotMuted($user);
        }

        parent::__construct($query, $request);
    }
}
