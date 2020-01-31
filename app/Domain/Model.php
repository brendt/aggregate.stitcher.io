<?php

namespace Domain;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Support\Models\PreventLazyLoading;

abstract class Model extends BaseModel
{
    use PreventLazyLoading;

    protected $guarded = [];
}
