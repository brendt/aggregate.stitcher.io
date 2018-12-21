<?php

namespace App\Domain\Post\Query;

use Illuminate\Database\Query\Builder;

class PostQueryBuilder extends Builder
{
    public function getCountForPagination($columns = ['*'])
    {
        return parent::getCountForPagination(['posts.id']);
    }
}
