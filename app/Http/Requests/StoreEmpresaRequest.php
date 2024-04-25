<?php

namespace App\Http\Requests;

use App\Models\Empresa;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmpresaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('empresa_create');
    }

    public function rules()
    {
        return [
            'direccion' => [
                'string',
                'nullable',
            ],
            'rut' => [
                'string',
                'required',
                'unique:empresas',
            ],
            'razon_social' => [
                'string',
                'required',
            ],
            'nombe_de_fantasia' => [
                'string',
                'nullable',
            ],
            'rubro' => [
                'string',
                'nullable',
            ],
        ];
    }
}
