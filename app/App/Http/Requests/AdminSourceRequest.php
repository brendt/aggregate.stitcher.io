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
                'unique:sources,url',
            ],
        ];
    }
}
