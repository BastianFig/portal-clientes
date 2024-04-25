<?php

namespace App\Http\Requests;

use App\Models\Encuestum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEncuestumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('encuestum_create');
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
