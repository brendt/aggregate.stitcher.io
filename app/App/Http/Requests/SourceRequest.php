<?php

namespace App\Http\Requests;

class SourceRequest extends Request
{
    public function rules(): array
    {
        return [
            'url' => 'required|string',
        ];
    }
}
