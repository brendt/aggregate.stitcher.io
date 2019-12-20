<?php

namespace App\Admin\Queries;

use Domain\Log\Loggable;
use Domain\Log\Models\ErrorLog;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AdminErrorLogQuery extends QueryBuilder
{
    public function __construct(Request $request)
    {
        $query = ErrorLog::query();

        parent::__construct($query, $request);

        $this->defaultSort('-created_at');
    }

    public function whereLoggable(Loggable $loggable): AdminErrorLogQuery
    {
        return $this
            ->where('loggable_type', $loggable->getMorphClass())
            ->where('loggable_id', $loggable->getKey());
    }
}
