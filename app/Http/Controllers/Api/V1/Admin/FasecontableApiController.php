<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreFasecontableRequest;
use App\Http\Requests\UpdateFasecontableRequest;
use App\Http\Resources\Admin\FasecontableResource;
use App\Models\Fasecontable;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FasecontableApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasecontable_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecontableResource(Fasecontable::with(['id_proyecto'])->get());
    }

    public function store(StoreFasecontableRequest $request)
    {
        $fasecontable = Fasecontable::create($request->all());

        if ($request->input('anticipo_50', false)) {
            $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_50'))))->toMediaCollection('anticipo_50');
        }

        if ($request->input('anticipo_40', false)) {
            $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_40'))))->toMediaCollection('anticipo_40');
        }

        if ($request->input('anticipo_10', false)) {
            $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_10'))))->toMediaCollection('anticipo_10');
        }

        return (new FasecontableResource($fasecontable))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Fasecontable $fasecontable)
    {
        abort_if(Gate::denies('fasecontable_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FasecontableResource($fasecontable->load(['id_proyecto']));
    }

    public function update(UpdateFasecontableRequest $request, Fasecontable $fasecontable)
    {
        $fasecontable->update($request->all());

        if ($request->input('anticipo_50', false)) {
            if (! $fasecontable->anticipo_50 || $request->input('anticipo_50') !== $fasecontable->anticipo_50->file_name) {
                if ($fasecontable->anticipo_50) {
                    $fasecontable->anticipo_50->delete();
                }
                $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_50'))))->toMediaCollection('anticipo_50');
            }
        } elseif ($fasecontable->anticipo_50) {
            $fasecontable->anticipo_50->delete();
        }

        if ($request->input('anticipo_40', false)) {
            if (! $fasecontable->anticipo_40 || $request->input('anticipo_40') !== $fasecontable->anticipo_40->file_name) {
                if ($fasecontable->anticipo_40) {
                    $fasecontable->anticipo_40->delete();
                }
                $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_40'))))->toMediaCollection('anticipo_40');
            }
        } elseif ($fasecontable->anticipo_40) {
            $fasecontable->anticipo_40->delete();
        }

        if ($request->input('anticipo_10', false)) {
            if (! $fasecontable->anticipo_10 || $request->input('anticipo_10') !== $fasecontable->anticipo_10->file_name) {
                if ($fasecontable->anticipo_10) {
                    $fasecontable->anticipo_10->delete();
                }
                $fasecontable->addMedia(storage_path('tmp/uploads/' . basename($request->input('anticipo_10'))))->toMediaCollection('anticipo_10');
            }
        } elseif ($fasecontable->anticipo_10) {
            $fasecontable->anticipo_10->delete();
        }

        return (new FasecontableResource($fasecontable))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Fasecontable $fasecontable)
    {
        abort_if(Gate::denies('fasecontable_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecontable->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
