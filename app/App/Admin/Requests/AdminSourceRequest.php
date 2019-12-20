<?php

namespace App\Admin\Requests;

use App\Feed\Requests\SourceRequest;
use Support\Rules\SupportedLanguageRule;

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
