<?php

namespace Support;

use Domain\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        self::saving(function (Model $model): void {
            if (! $model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
