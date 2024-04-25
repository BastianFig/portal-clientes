<?php

namespace App\Http\Requests;

use App\Models\Fasecomercial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFasecomercialRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fasecomercial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fasecomercials,id',
        ];
    }
}
