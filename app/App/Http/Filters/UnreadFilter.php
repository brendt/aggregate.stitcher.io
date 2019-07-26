<?php

namespace App\Http\Filters;

use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

final class UnreadFilter implements Filter
{
    /** @var \Domain\User\Models\User */
    private $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder|\Domain\Post\Models\Post $query
     * @param $value
     * @param string $property
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($this->user === null) {
            return $query;
        }

        return $query->whereUnread($this->user);
    }
}
