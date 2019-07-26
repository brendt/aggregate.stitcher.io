<?php

namespace App\Http\Requests;

class AdminTopicRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
