<?php

namespace App\Http\Requests;

use App\Models\Fasedespacho;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFasedespachoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasedespacho_create');
    }

    public function rules()
    {
        return [
            'fecha_despacho' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'galeria_estado_muebles' => [
                'array',
            ],
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
