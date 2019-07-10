<?php

namespace App\Http\Requests;

use App\Http\Rules\SupportedLanguageRule;

class RemoveLanguageRequest extends Request
{
    public function rules(): array
    {
        return [
            'language' => ['required', app(SupportedLanguageRule::class)],
        ];
    }
}
