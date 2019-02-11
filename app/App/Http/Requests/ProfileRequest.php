<?php

namespace App\Http\Requests;

class ProfileRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['password' => 'string|min:6|confirmed'];
    }
}
