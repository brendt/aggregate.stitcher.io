<?php

namespace App\User\Requests;

use App\Feed\Requests\SourceRequest;

class UserInterestsRequest extends SourceRequest
{
    public function rules(): array
    {
        return [
            'topics' => 'array',
        ];
    }
}
