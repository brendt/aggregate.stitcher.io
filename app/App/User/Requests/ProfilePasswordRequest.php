<?php

namespace App\User\Requests;

use Support\Requests\Request;

class ProfilePasswordRequest extends Request
{
    public function rules(): array
    {
        return ['password' => 'string|min:6|confirmed'];
    }
}
