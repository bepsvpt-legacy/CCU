<?php

namespace App\Http\Requests\Member;

use App\Http\Requests\Request;

class NicknameRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => [
                'required',
                'between:5,16',
                'regex:/^\w{5,16}$/',
                'unique:users,nickname,' . $this->user()->user->account_id . ',account_id'
            ],
        ];
    }
}
