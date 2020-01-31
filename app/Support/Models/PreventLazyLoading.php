<?php

namespace Support\Models;

use App\Support\Model\RelationLoadingException;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait PreventLazyLoading
{
    private static $log;

    protected function getRelationshipFromMethod($method)
    {
        if (! config('database.prevent_lazy_loading')) {
            return parent::getRelationshipFromMethod($method);
        }

        self::$log[] = get_class($this) . '::' . $method . '()';

        $whitelist = $this->allowedLazyRelations ?? [];

        if ($this->exists && ! in_array($method, $whitelist)) {
            $model = get_class($this);

            throw RelationLoadingException::make($model, $method, self::$log);
        }

        return parent::getRelationshipFromMethod($method);
    }
}
