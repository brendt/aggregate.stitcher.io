<?php

namespace App\Http\Requests;

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
        ];
    }
}
