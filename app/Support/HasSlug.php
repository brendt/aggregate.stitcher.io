<?php

namespace Support;

use Domain\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        self::saving(function (Model $model) {
            if (! $model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
