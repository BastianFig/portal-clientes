<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFaseDisenoRequest;
use App\Http\Requests\UpdateFaseDisenoRequest;
use App\Http\Resources\Admin\FaseDisenoResource;
use App\Models\FaseDiseno;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FaseDisenoApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fase_diseno_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FaseDisenoResource(FaseDiseno::with(['id_proyecto'])->get());
    }

    public function store(StoreFaseDisenoRequest $request)
    {
        $faseDiseno = FaseDiseno::create($request->all());

        foreach ($request->input('imagenes', []) as $file) {
            $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('imagenes');
        }

        foreach ($request->input('propuesta', []) as $file) {
            $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('propuesta');
        }

        return (new FaseDisenoResource($faseDiseno))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FaseDisenoResource($faseDiseno->load(['id_proyecto']));
    }

    public function update(UpdateFaseDisenoRequest $request, FaseDiseno $faseDiseno)
    {
        $faseDiseno->update($request->all());

        if (count($faseDiseno->imagenes) > 0) {
            foreach ($faseDiseno->imagenes as $media) {
                if (! in_array($media->file_name, $request->input('imagenes', []))) {
                    $media->delete();
                }
            }
        }
        $media = $faseDiseno->imagenes->pluck('file_name')->toArray();
        foreach ($request->input('imagenes', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('imagenes');
            }
        }

        if (count($faseDiseno->propuesta) > 0) {
            foreach ($faseDiseno->propuesta as $media) {
                if (! in_array($media->file_name, $request->input('propuesta', []))) {
                    $media->delete();
                }
            }
        }
        $media = $faseDiseno->propuesta->pluck('file_name')->toArray();
        foreach ($request->input('propuesta', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $faseDiseno->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('propuesta');
            }
        }

        return (new FaseDisenoResource($faseDiseno))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faseDiseno->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
