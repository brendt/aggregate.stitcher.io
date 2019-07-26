<?php

namespace App\Http\Requests;

class AdminTagRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'keywords' => ['required', 'string'],
            'color' => ['required', 'string'],
            'topic_id' => ['required', 'exists:topics,id'],
        ];
    }
}
