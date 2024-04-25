<?php

namespace App\Http\Requests;

use App\Models\FasePostventum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateFasePostventumRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('fase_postventum_edit');
    }

    public function rules()
    {
        return [
            'id_usuarios.*' => [
                'integer',
            ],
            'id_usuarios' => [
                'array',
            ],
            'estado' => [
                'string',
                'nullable',
            ],
        ];
    }
}
