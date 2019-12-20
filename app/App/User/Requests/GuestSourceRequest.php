<?php

namespace App\User\Requests;

use App\Feed\Requests\SourceRequest;
use Support\Rules\SupportedLanguageRule;

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
