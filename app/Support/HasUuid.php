<?php

namespace Support;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        self::creating(function (Model $model) {
            if ($model->uuid !== null) {
                return $model;
            }

            $model->uuid = Uuid::uuid4();

            return $model;
        });
    }

    public function scopeWhereUuid(Builder $builder, string $uuid): Builder
    {
        return $builder->where('uuid', $uuid);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function getRouteKey(): string
    {
        return $this->uuid;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}
