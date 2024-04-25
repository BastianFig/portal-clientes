<?php

namespace App\Http\Requests;

use App\Models\Fasecontable;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFasecontableRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fasecontable_edit');
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
