<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFasefabricaRequest;
use App\Http\Requests\UpdateFasefabricaRequest;
use App\Http\Resources\Admin\FasefabricaResource;
use App\Models\Fasefabrica;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasefabricaApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasefabrica_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasefabricaResource(Fasefabrica::with(['id_proyecto'])->get());
    }

    public function store(StoreFasefabricaRequest $request)
    {
        $fasefabrica = Fasefabrica::create($request->all());

        foreach ($request->input('oc_proveedores', []) as $file) {
            $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
        }

        foreach ($request->input('galeria_estado_entrega', []) as $file) {
            $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
        }

        return (new FasefabricaResource($fasefabrica))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasefabricaResource($fasefabrica->load(['id_proyecto']));
    }

    public function update(UpdateFasefabricaRequest $request, Fasefabrica $fasefabrica)
    {
        $fasefabrica->update($request->all());

        if (count($fasefabrica->oc_proveedores) > 0) {
            foreach ($fasefabrica->oc_proveedores as $media) {
                if (! in_array($media->file_name, $request->input('oc_proveedores', []))) {
                    $media->delete();
                }
            }
        }
        $media = $fasefabrica->oc_proveedores->pluck('file_name')->toArray();
        foreach ($request->input('oc_proveedores', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
            }
        }

        if (count($fasefabrica->galeria_estado_entrega) > 0) {
            foreach ($fasefabrica->galeria_estado_entrega as $media) {
                if (! in_array($media->file_name, $request->input('galeria_estado_entrega', []))) {
                    $media->delete();
                }
            }
        }
        $media = $fasefabrica->galeria_estado_entrega->pluck('file_name')->toArray();
        foreach ($request->input('galeria_estado_entrega', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
            }
        }

        return (new FasefabricaResource($fasefabrica))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasefabrica->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
