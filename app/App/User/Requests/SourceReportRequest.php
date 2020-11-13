<?php

namespace App\User\Requests;

use Support\Requests\Request;

class SourceReportRequest
    extends Request
{
    public function rules(): array
    {
        return [
            'report' => ['required', 'string'],
        ];
    }
}
