<?php

namespace App\Http\Requests;

use App\Http\Rules\UniqueSourceRule;
use App\Http\Rules\SupportedLanguage;

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
            'language' => [
                'string',
                'nullable',
                new SupportedLanguage(),
            ]
        ];
    }
}
