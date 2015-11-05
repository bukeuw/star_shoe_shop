<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MemberLoginRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Nama tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'g-recaptcha-response.required' => 'Silahkan verifikasi captcha terlebih dahulu'
        ];
    }
}
