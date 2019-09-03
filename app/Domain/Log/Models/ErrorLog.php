<?php

namespace Domain\Log\Models;

use Domain\Log\Collections\ErrorLogCollection;
use Domain\Log\Loggable;
use Domain\Model;
use Exception;

class ErrorLog extends Model
{
    public static function createFromException(
        Exception $exception,
        Loggable $loggable
    ): ErrorLog {
        return self::create([
            'loggable_type' => $loggable->getMorphClass(),
            'loggable_id' => $loggable->getKey(),
            'message' => $exception->getMessage(),
            'body' => $exception->getTraceAsString(),
        ]);
    }

    public function newCollection(array $models = [])
    {
        return new ErrorLogCollection($models);
    }

    public function loggable(): void
    {
        $this->morphTo();
    }

    public function getLoggable(): Loggable
    {
        return $this->loggable;
    }
}
