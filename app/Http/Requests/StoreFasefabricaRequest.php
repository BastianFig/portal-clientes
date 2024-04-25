<?php

namespace App\Http\Requests;

use App\Models\Fasefabrica;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFasefabricaRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasefabrica_create');
    }

    public function rules()
    {
        return [
            'oc_proveedores' => [
                'array',
            ],
            'fecha_entrega' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'galeria_estado_entrega' => [
                'array',
            ],
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
