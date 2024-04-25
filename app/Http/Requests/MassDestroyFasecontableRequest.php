<?php

namespace App\Http\Requests;

use App\Models\Fasecontable;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFasecontableRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fasecontable_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fasecontables,id',
        ];
    }
}
