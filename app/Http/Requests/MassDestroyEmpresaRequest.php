<?php

namespace App\Http\Requests;

use App\Models\Empresa;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmpresaRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('empresa_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:empresas,id',
        ];
    }
}
