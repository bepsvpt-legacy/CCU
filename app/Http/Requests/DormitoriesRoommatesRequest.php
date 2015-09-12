<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DormitoriesRoommatesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (str_contains($fb = $this->input('fb'), 'm.facebook.com'));{
            $this->merge(['fb' => str_replace('m.facebook.com', 'www.facebook.com', $fb)]);
        }

        return [
            'room' => ['required', 'regex:/^[1-5][1-9](0[1-9]|1[0-6])$/'],
            'bed' => 'required|in:A,B,C,D',
            'name' => ['required', 'max:8', 'regex:/[^\d\s\w]/'],
            'fb' => ['required', 'url', 'not_in:https://www.facebook.com/bepsv.pt', 'regex:/^https:\/\/(www|m)\.facebook\.com/'],
            'g-recaptcha-response' => 'required|recaptcha',
        ];
    }
}
