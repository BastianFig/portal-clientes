<?php

namespace App\Http\Requests;

use App\Models\Fasecomercialproyecto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFasecomercialproyectoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasecomercialproyecto_create');
    }

    public function rules()
    {
        return [
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
