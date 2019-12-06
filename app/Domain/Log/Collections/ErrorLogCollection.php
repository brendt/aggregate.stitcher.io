<?php

namespace Domain\Log\Collections;

use Domain\Log\Models\ErrorLog;
use Illuminate\Database\Eloquent\Collection;

final class ErrorLogCollection extends Collection
{
    public function lastWeek(): ErrorLogCollection
    {
        return $this->filter(fn (ErrorLog $errorLog) => $errorLog->created_at > now()->subWeek());
    }
}
