<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|max:25',
            'rut' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password2'=> 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'password2.same' => 'La contraseña no coincide'
        ];
    }
}
