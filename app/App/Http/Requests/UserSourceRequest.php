<?php

namespace App\Http\Requests;

use App\Http\Rules\UniqueSourceRule;

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
                'exists:topics,id'
            ],
        ];
    }
}
