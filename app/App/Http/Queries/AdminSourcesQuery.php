<?php

namespace App\Http\Queries;

use Domain\Source\Models\Source;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AdminSourcesQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = Source::query();

        parent::__construct($query, $request);

        $this->defaultSort('is_active');
    }
}
