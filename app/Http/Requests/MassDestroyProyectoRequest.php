<?php

namespace App\Http\Requests;

use App\Models\Proyecto;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyProyectoRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('proyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:proyectos,id',
        ];
    }
}
