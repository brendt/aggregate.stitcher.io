<?php

namespace App\Http\Controllers;

use App\Http\Queries\AdminErrorLogQuery;
use App\Http\ViewModels\AdminErrorLogViewModel;
use Illuminate\Database\Eloquent\Relations\Relation;

final class AdminErrorLogController
{
    public function index(
        string $type,
        string $id,
        AdminErrorLogQuery $adminErrorLogQuery
    ) {
        $loggableClass = Relation::$morphMap[$type];

        /** @var \Domain\Log\Loggable $loggable */
        $loggable = forward_static_call_array("{$loggableClass}::findOrFail", [$id]);

        $errorLogs = $adminErrorLogQuery
            ->whereLoggable($loggable)
            ->paginate(50);

        return (new AdminErrorLogViewModel($loggable, $errorLogs))
            ->view('adminErrorLog.index');
    }
}
