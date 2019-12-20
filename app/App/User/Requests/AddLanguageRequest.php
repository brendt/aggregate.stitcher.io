<?php

namespace App\User\Requests;

use Support\Requests\Request;
use Support\Rules\SupportedLanguageRule;

class AddLanguageRequest extends Request
{
    public function rules(): array
    {
        return [
            'language' => ['required', app(SupportedLanguageRule::class)],
        ];
    }
}
