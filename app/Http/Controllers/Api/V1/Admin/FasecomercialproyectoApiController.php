<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFasecomercialproyectoRequest;
use App\Http\Requests\UpdateFasecomercialproyectoRequest;
use App\Http\Resources\Admin\FasecomercialproyectoResource;
use App\Models\Fasecomercialproyecto;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasecomercialproyectoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasecomercialproyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecomercialproyectoResource(Fasecomercialproyecto::with(['id_proyecto'])->get());
    }

    public function store(StoreFasecomercialproyectoRequest $request)
    {
        $fasecomercialproyecto = Fasecomercialproyecto::create($request->all());

        if ($request->input('nota_venta', false)) {
            $fasecomercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
        }

        return (new FasecomercialproyectoResource($fasecomercialproyecto))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fasecomercialproyecto $fasecomercialproyecto)
    {
        abort_if(Gate::denies('fasecomercialproyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecomercialproyectoResource($fasecomercialproyecto->load(['id_proyecto']));
    }

    public function update(UpdateFasecomercialproyectoRequest $request, Fasecomercialproyecto $fasecomercialproyecto)
    {
        $fasecomercialproyecto->update($request->all());

        if ($request->input('nota_venta', false)) {
            if (! $fasecomercialproyecto->nota_venta || $request->input('nota_venta') !== $fasecomercialproyecto->nota_venta->file_name) {
                if ($fasecomercialproyecto->nota_venta) {
                    $fasecomercialproyecto->nota_venta->delete();
                }
                $fasecomercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
            }
        } elseif ($fasecomercialproyecto->nota_venta) {
            $fasecomercialproyecto->nota_venta->delete();
        }

        return (new FasecomercialproyectoResource($fasecomercialproyecto))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fasecomercialproyecto $fasecomercialproyecto)
    {
        abort_if(Gate::denies('fasecomercialproyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercialproyecto->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
