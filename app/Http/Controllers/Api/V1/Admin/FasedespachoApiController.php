<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFasedespachoRequest;
use App\Http\Requests\UpdateFasedespachoRequest;
use App\Http\Resources\Admin\FasedespachoResource;
use App\Models\Fasedespacho;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasedespachoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasedespacho_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasedespachoResource(Fasedespacho::with(['id_proyecto'])->get());
    }

    public function store(StoreFasedespachoRequest $request)
    {
        $fasedespacho = Fasedespacho::create($request->all());

        if ($request->input('guia_despacho', false)) {
            $fasedespacho->addMedia(storage_path('tmp/uploads/' . basename($request->input('guia_despacho'))))->toMediaCollection('guia_despacho');
        }

        foreach ($request->input('galeria_estado_muebles', []) as $file) {
            $fasedespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_muebles');
        }

        return (new FasedespachoResource($fasedespacho))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasedespachoResource($fasedespacho->load(['id_proyecto']));
    }

    public function update(UpdateFasedespachoRequest $request, Fasedespacho $fasedespacho)
    {
        $fasedespacho->update($request->all());

        if ($request->input('guia_despacho', false)) {
            if (! $fasedespacho->guia_despacho || $request->input('guia_despacho') !== $fasedespacho->guia_despacho->file_name) {
                if ($fasedespacho->guia_despacho) {
                    $fasedespacho->guia_despacho->delete();
                }
                $fasedespacho->addMedia(storage_path('tmp/uploads/' . basename($request->input('guia_despacho'))))->toMediaCollection('guia_despacho');
            }
        } elseif ($fasedespacho->guia_despacho) {
            $fasedespacho->guia_despacho->delete();
        }

        if (count($fasedespacho->galeria_estado_muebles) > 0) {
            foreach ($fasedespacho->galeria_estado_muebles as $media) {
                if (! in_array($media->file_name, $request->input('galeria_estado_muebles', []))) {
                    $media->delete();
                }
            }
        }
        $media = $fasedespacho->galeria_estado_muebles->pluck('file_name')->toArray();
        foreach ($request->input('galeria_estado_muebles', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $fasedespacho->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_muebles');
            }
        }

        return (new FasedespachoResource($fasedespacho))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasedespacho->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
