<?php

namespace App\Http\Requests;

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
                'exists:topics,id'
            ],
        ];
    }
}
