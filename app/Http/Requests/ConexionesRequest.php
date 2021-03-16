<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConexionesRequest extends FormRequest
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
            'empresa' => 'required',
            'ruta' => 'required',
            //'host_principal' => 'required|ip',
            //'puerto_principal' => 'required|numeric',
            //'usuario_principal' => 'required',
            //'contrasena_principal' => 'required',
        ];
    }

    public function attributes()
    {
        return[
            'empresa' => 'Empresa',
            'ruta' => 'Ruta',
            //'host_principal' => 'Host Pricipal',
            //'puerto_principal' => 'Puerto Principal',
            //'usuario_principal' => 'Usuario Principal',
            //'contrasena_principal' => 'Contraseña Principal',
        ];
    }
}
