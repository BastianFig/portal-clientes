<?php

namespace App\Http\Requests;

use App\Models\Fasecontable;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFasecontableRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasecontable_create');
    }

    public function rules()
    {
        return [
            'comentario' => [
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
