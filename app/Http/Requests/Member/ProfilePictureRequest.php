<?php

namespace App\Http\Requests\Member;

use App\Http\Requests\Request;

class ProfilePictureRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|mimes:jpeg,png|max:4096',
        ];
    }
}
