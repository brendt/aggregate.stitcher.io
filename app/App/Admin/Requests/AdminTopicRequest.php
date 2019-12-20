<?php

namespace App\Admin\Requests;

use Support\Requests\Request;

class AdminTopicRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
        ];
    }
}
