<?php

namespace App\Http\Requests;

use App\Models\Sucursal;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSucursalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sucursal_edit');
    }

    public function rules()
    {
        return [
            'nombre' => [
                'string',
                'nullable',
            ],
            'direccion_sucursal' => [
                'string',
                'nullable',
            ],
            'empresa_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
