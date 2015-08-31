<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CoursesCommentsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|min:10|max:1000',
            'anonymous' => 'boolean'
        ];
    }
}