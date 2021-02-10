<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'empresa' => 'required',
            'rol' => 'required',
        ];
    }

    public function attributes()
    {
        return[
            'name' => 'Nombre',
            'email' => 'E-mail',
            'password' => 'Contraseña',
            'password_confirmation' => 'Contraseña',
            'empresa' => 'Empresa',
            'rol' => 'Rol',
        ];
    }
}
