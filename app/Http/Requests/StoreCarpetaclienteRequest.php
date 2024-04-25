<?php

namespace App\Http\Requests;

use App\Models\Carpetacliente;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCarpetaclienteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('carpetacliente_create');
    }

    public function rules()
    {
        return [
            'plano' => [
                'array',
            ],
            'fftt' => [
                'array',
            ],
            'presentacion' => [
                'array',
            ],
        ];
    }
}
