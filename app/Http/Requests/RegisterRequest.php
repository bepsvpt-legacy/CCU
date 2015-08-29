<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required', 'email', 'max:96',
                'regex:/^((?!bepsvpt).)*$/',
                'unique:accounts',
            ],
            'domain' => 'exists:whitelist_mail_servers',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }

    /**
     * Set custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'domain.exists' => '您的信箱不在白名單內，如對此有問題，請聯繫管理員',
        ];
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $domain = (false === ($pos = strpos($email = $this->input('email', ''), '@'))) ? '' : substr($email, $pos + 1);

        $this->merge(['domain' => $domain]);

        return parent::getValidatorInstance();
    }
}
