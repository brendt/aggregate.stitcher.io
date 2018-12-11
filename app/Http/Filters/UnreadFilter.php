<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

final class UnreadFilter implements Filter
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Post $query
     * @param $value
     * @param string $property
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        return $query->whereUnread();
    }
}
