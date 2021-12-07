<?php

namespace Victoranw\Laradoc\Http\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

use ErrorC;

class LoginRequest extends FormRequest
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
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'login.required' =>  "L'identifiant est obligatoire",
            'login.string' =>  "L'identifiant n'est pas au bon format",
            'password.required' => "Le mot de passe est obligatoire",
            'password.string' =>  "L'identifiant n'est pas au bon format",
        ];
    }
}
