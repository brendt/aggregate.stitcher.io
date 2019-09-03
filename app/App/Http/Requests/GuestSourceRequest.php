<?php

namespace App\Http\Requests;

use App\Http\Rules\SupportedLanguageRule;

class GuestSourceRequest extends SourceRequest
{
    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'string',
            ],
            'topic_ids[]' => [
                'nullable',
                'numeric',
                'exists:topics,id',
            ],
            'language' => [
                'string',
                'nullable',
                app(SupportedLanguageRule::class),
            ],
        ];
    }
}
