<?php

namespace App\Http\Requests;

use App\Http\Rules\SupportedLanguageRule;

class AdminSourceRequest extends SourceRequest
{
    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'string',
                'unique:sources,url',
            ],
            'language' => [
                'string',
                'nullable',
                new SupportedLanguageRule(),
            ],
        ];
    }
}
