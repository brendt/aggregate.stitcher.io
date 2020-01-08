<?php

namespace Domain\Source\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Support\Requests\Request;

final class SourceQueryBuilder extends Builder
{
    public function applySort(Request $request): SourceQueryBuilder
    {
        $sort = $request->get('sort');

        if (! $sort) {
            return $this;
        }

        $isDescending = strpos($sort, '-') === 0;

        if ($isDescending) {
            $sort = substr($sort, 1);
        }

        return $this->orderBy($sort, $isDescending ? 'desc' : 'asc');
    }

    public function joinPosts(): SourceQueryBuilder
    {
        return $this->join('posts', 'posts.source_id', '=', 'sources.id');
    }
}
