<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresasRequest extends FormRequest
{
       /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razon_social' => 'required',
            'intercompania' => 'required',
            'url_respaldo' => 'required',
            'no_respaldos' => 'required'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return[
            'razon_social' => 'Razon Social',
            'intercompania' => 'Intercompañia',
            'url_respaldo' => 'Ruta Respaldos',
            'no_respaldos' => 'Número de Respaldos',
        ];
    }
}
