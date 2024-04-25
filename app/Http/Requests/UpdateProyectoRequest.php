<?php

namespace App\Http\Requests;

use App\Models\Proyecto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProyectoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('proyecto_edit');
    }

    public function rules()
    {
        return [
            'id_cliente_id' => [
                'required',
                'integer',
            ],
            'id_usuarios_clientes.*' => [
                'integer',
            ],
            'id_usuarios_clientes' => [
                'required',
                'array',
            ],
            'nombre_proyecto' => [
                'string',
                'required',
            ],
            'id_vendedor' => [
                'string',
                'required',
            ],
        ];
    }
}
