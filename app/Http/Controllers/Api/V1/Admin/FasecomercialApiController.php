<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFasecomercialRequest;
use App\Http\Requests\UpdateFasecomercialRequest;
use App\Http\Resources\Admin\FasecomercialResource;
use App\Models\Fasecomercial;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasecomercialApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasecomercial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecomercialResource(Fasecomercial::with(['id_proyecto'])->get());
    }

    public function store(StoreFasecomercialRequest $request)
    {
        $fasecomercial = Fasecomercial::create($request->all());

        if ($request->input('cotizacion', false)) {
            $fasecomercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('cotizacion'))))->toMediaCollection('cotizacion');
        }

        if ($request->input('oc', false)) {
            $fasecomercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('oc'))))->toMediaCollection('oc');
        }

        return (new FasecomercialResource($fasecomercial))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fasecomercial $fasecomercial)
    {
        abort_if(Gate::denies('fasecomercial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecomercialResource($fasecomercial->load(['id_proyecto']));
    }

    public function update(UpdateFasecomercialRequest $request, Fasecomercial $fasecomercial)
    {
        $fasecomercial->update($request->all());

        if ($request->input('cotizacion', false)) {
            if (! $fasecomercial->cotizacion || $request->input('cotizacion') !== $fasecomercial->cotizacion->file_name) {
                if ($fasecomercial->cotizacion) {
                    $fasecomercial->cotizacion->delete();
                }
                $fasecomercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('cotizacion'))))->toMediaCollection('cotizacion');
            }
        } elseif ($fasecomercial->cotizacion) {
            $fasecomercial->cotizacion->delete();
        }

        if ($request->input('oc', false)) {
            if (! $fasecomercial->oc || $request->input('oc') !== $fasecomercial->oc->file_name) {
                if ($fasecomercial->oc) {
                    $fasecomercial->oc->delete();
                }
                $fasecomercial->addMedia(storage_path('tmp/uploads/' . basename($request->input('oc'))))->toMediaCollection('oc');
            }
        } elseif ($fasecomercial->oc) {
            $fasecomercial->oc->delete();
        }

        return (new FasecomercialResource($fasecomercial))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fasecomercial $fasecomercial)
    {
        abort_if(Gate::denies('fasecomercial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercial->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
