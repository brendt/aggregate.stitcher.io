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
            ],
            'twitter_handle' => 'nullable|string',
            'topics' => 'array',
            'is_active' => 'boolean',
            'is_validated' => 'boolean',
            'language' => [
                'string',
                'nullable',
                app(SupportedLanguageRule::class),
            ],
        ];
    }
}
