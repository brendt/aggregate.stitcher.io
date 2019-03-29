<?php

namespace Domain\Log;

use Domain\Log\Collections\ErrorLogCollection;
use Domain\Log\Models\ErrorLog;
use Exception;
use Support\Polymorphic;

interface Loggable extends Polymorphic
{
    public function getErrorLogs(): ErrorLogCollection;

    public function logException(Exception $exception): ErrorLog;

    public function getName(): string;
}
