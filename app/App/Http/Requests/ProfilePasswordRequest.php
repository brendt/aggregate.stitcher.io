<?php

namespace App\Http\Requests;

class ProfilePasswordRequest extends Request
{
    public function rules(): array
    {
        return ['password' => 'string|min:6|confirmed'];
    }
}
