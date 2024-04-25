<?php

namespace App\Http\Requests;

use App\Models\FaseDiseno;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFaseDisenoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fase_diseno_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fase_disenos,id',
        ];
    }
}
