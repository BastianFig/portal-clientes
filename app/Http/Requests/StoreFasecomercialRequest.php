<?php

namespace App\Http\Requests;

use App\Models\Fasecomercial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFasecomercialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasecomercial_create');
    }

    public function rules()
    {
        return [
            'comentarios' => [
                'string',
                'nullable',
            ],
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
