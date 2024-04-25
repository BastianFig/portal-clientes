<?php

namespace App\Http\Requests;

use App\Models\Fasecomercialproyecto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFasecomercialproyectoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasecomercialproyecto_edit');
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
