<?php

namespace App\User\Requests;

use App\Feed\Requests\SourceRequest;
use Domain\Source\Rules\UniqueSourceRule;
use Support\Rules\SupportedLanguageRule;

class UserSourceRequest extends SourceRequest
{
    public function rules(): array
    {
        /** @var \Domain\User\Models\User $user */
        $user = $this->user();

        $primarySource = $user->getPrimarySource();

        return [
            'url' => [
                'required',
                'string',
                new UniqueSourceRule($primarySource ? $primarySource->id : null),
            ],
            'twitter_handle' => 'nullable|string',
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
