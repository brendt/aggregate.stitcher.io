<?php

namespace App\Admin\Controllers;

use App\Admin\Queries\AdminErrorLogQuery;
use App\Admin\ViewModels\AdminErrorLogViewModel;
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
