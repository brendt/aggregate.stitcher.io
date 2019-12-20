<?php

namespace App\User\Requests;

use Support\Requests\Request;
use Support\Rules\SupportedLanguageRule;

class RemoveLanguageRequest extends Request
{
    public function rules(): array
    {
        return [
            'language' => ['required', app(SupportedLanguageRule::class)],
        ];
    }
}
