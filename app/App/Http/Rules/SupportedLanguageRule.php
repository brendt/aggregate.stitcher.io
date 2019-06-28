<?php

namespace App\Http\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class SupportedLanguageRule implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value): bool
    {
        return Arr::has(get_supported_languages(), $value);
    }

    public function message()
    {
        return __("This language isn't supported.");
    }
}
