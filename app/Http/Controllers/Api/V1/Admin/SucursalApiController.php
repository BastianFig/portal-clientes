<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSucursalRequest;
use App\Http\Requests\UpdateSucursalRequest;
use App\Http\Resources\Admin\SucursalResource;
use App\Models\Sucursal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SucursalApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sucursal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SucursalResource(Sucursal::with(['empresa'])->get());
    }

    public function store(StoreSucursalRequest $request)
    {
        $sucursal = Sucursal::create($request->all());

        return (new SucursalResource($sucursal))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SucursalResource($sucursal->load(['empresa']));
    }

    public function update(UpdateSucursalRequest $request, Sucursal $sucursal)
    {
        $sucursal->update($request->all());

        return (new SucursalResource($sucursal))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sucursal->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
