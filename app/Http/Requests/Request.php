<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = (func_num_args() > 0) ? (array) func_get_arg(0) : [];

        if ((method_exists($this, 'rules')) && (isset($this->rules()['g-recaptcha-response']))) {
            if ('validation.recaptcha' === ($lang = trans('validation.recaptcha'))) {
                $lang = 'Please ensure that you are a human!';
            }

            $messages['g-recaptcha-response.required'] = $lang;
        }

        return $messages;
    }
}
