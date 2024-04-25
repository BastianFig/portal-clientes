<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Resources\Admin\EmpresaResource;
use App\Models\Empresa;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresaApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('empresa_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmpresaResource(Empresa::all());
    }

    public function store(StoreEmpresaRequest $request)
    {
        $empresa = Empresa::create($request->all());

        return (new EmpresaResource($empresa))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmpresaResource($empresa);
    }

    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->all());

        return (new EmpresaResource($empresa))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresa->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
