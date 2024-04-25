<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Http\Resources\Admin\ProyectoResource;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProyectoApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('proyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProyectoResource(Proyecto::with(['id_cliente', 'id_usuarios_clientes', 'sucursal'])->get());
    }

    public function store(StoreProyectoRequest $request)
    {
        $proyecto = Proyecto::create($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        return (new ProyectoResource($proyecto))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProyectoResource($proyecto->load(['id_cliente', 'id_usuarios_clientes', 'sucursal']));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto)
    {
        $proyecto->update($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        return (new ProyectoResource($proyecto))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyecto->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
