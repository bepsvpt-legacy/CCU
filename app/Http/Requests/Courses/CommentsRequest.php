<?php

namespace App\Http\Requests\Courses;

use App\Http\Requests\Request;

class CommentsRequest extends Request
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