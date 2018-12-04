<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    public static function bootHasUuid()
    {
        self::creating(function (Model $model) {
            if ($model->uuid !== null) {
                return $model;
            }

            $model->uuid = Uuid::uuid1();

            return $model;
        });
    }

    public function scopeWhereUuid(Builder $builder, string $uuid): Builder
    {
        return $builder->where('uuid', $uuid);
    }
}
