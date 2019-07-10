<?php

namespace App\Http\Requests;

use App\Http\Rules\SupportedLanguageRule;

class AddLanguageRequest extends Request
{
    public function rules(): array
    {
        return [
            'language' => ['required', app(SupportedLanguageRule::class)],
        ];
    }
}
