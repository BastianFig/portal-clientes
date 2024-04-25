<?php

namespace App\Http\Requests;

use App\Models\FaseDiseno;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFaseDisenoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fase_diseno_edit');
    }

    public function rules()
    {
        return [
            'descripcion' => [
                'string',
                'nullable',
            ],
            'imagenes' => [
                'array',
            ],
            'propuesta' => [
                'array',
            ],
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
