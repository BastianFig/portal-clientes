<?php

namespace App\Http\Requests;

use App\Models\FasePostventum;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyFasePostventumRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('fase_postventum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:fase_postventa,id',
        ];
    }
}
