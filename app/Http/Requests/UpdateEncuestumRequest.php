<?php

namespace App\Http\Requests;

use App\Models\Encuestum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEncuestumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('encuestum_edit');
    }

    public function rules()
    {
        return [
            'observacion' => [
                'string',
                'nullable',
            ],
        ];
    }
}
