<?php

namespace App\Http\Requests;

use App\Http\Rules\UniqueSourceRule;

class SourceRequest extends Request
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
        ];
    }

    public function getTwitterHandle(): ?string
    {
        return $this->get('twitter_handle');
    }

    public function getSourceUrl(): string
    {
        return $this->get('url');
    }
}
