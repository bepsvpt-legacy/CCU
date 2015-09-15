<?php

namespace App\Http\Requests\Courses;

use App\Http\Requests\Request;

class ExamsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'semester' => 'required|exists:categories,id,category,courses.semester',
            'file' => 'required|mimes:jpeg,bmp,png,pdf|max:4096',
        ];
    }
}
