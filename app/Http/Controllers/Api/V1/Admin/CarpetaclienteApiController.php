<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCarpetaclienteRequest;
use App\Http\Requests\UpdateCarpetaclienteRequest;
use App\Http\Resources\Admin\CarpetaclienteResource;
use App\Models\Carpetacliente;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarpetaclienteApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('carpetacliente_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarpetaclienteResource(Carpetacliente::with(['id_fase_comercial'])->get());
    }

    public function store(StoreCarpetaclienteRequest $request)
    {
        $carpetacliente = Carpetacliente::create($request->all());

        if ($request->input('presupuesto', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
        }

        foreach ($request->input('plano', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
        }

        foreach ($request->input('fftt', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
        }

        foreach ($request->input('presentacion', []) as $file) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
        }

        if ($request->input('rectificacion', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
        }

        if ($request->input('nb', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
        }

        if ($request->input('course', false)) {
            $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
        }

        return (new CarpetaclienteResource($carpetacliente))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CarpetaclienteResource($carpetacliente->load(['id_fase_comercial']));
    }

    public function update(UpdateCarpetaclienteRequest $request, Carpetacliente $carpetacliente)
    {
        $carpetacliente->update($request->all());

        if ($request->input('presupuesto', false)) {
            if (! $carpetacliente->presupuesto || $request->input('presupuesto') !== $carpetacliente->presupuesto->file_name) {
                if ($carpetacliente->presupuesto) {
                    $carpetacliente->presupuesto->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('presupuesto'))))->toMediaCollection('presupuesto');
            }
        } elseif ($carpetacliente->presupuesto) {
            $carpetacliente->presupuesto->delete();
        }

        if (count($carpetacliente->plano) > 0) {
            foreach ($carpetacliente->plano as $media) {
                if (! in_array($media->file_name, $request->input('plano', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->plano->pluck('file_name')->toArray();
        foreach ($request->input('plano', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('plano');
            }
        }

        if (count($carpetacliente->fftt) > 0) {
            foreach ($carpetacliente->fftt as $media) {
                if (! in_array($media->file_name, $request->input('fftt', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->fftt->pluck('file_name')->toArray();
        foreach ($request->input('fftt', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('fftt');
            }
        }

        if (count($carpetacliente->presentacion) > 0) {
            foreach ($carpetacliente->presentacion as $media) {
                if (! in_array($media->file_name, $request->input('presentacion', []))) {
                    $media->delete();
                }
            }
        }
        $media = $carpetacliente->presentacion->pluck('file_name')->toArray();
        foreach ($request->input('presentacion', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('presentacion');
            }
        }

        if ($request->input('rectificacion', false)) {
            if (! $carpetacliente->rectificacion || $request->input('rectificacion') !== $carpetacliente->rectificacion->file_name) {
                if ($carpetacliente->rectificacion) {
                    $carpetacliente->rectificacion->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('rectificacion'))))->toMediaCollection('rectificacion');
            }
        } elseif ($carpetacliente->rectificacion) {
            $carpetacliente->rectificacion->delete();
        }

        if ($request->input('nb', false)) {
            if (! $carpetacliente->nb || $request->input('nb') !== $carpetacliente->nb->file_name) {
                if ($carpetacliente->nb) {
                    $carpetacliente->nb->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('nb'))))->toMediaCollection('nb');
            }
        } elseif ($carpetacliente->nb) {
            $carpetacliente->nb->delete();
        }

        if ($request->input('course', false)) {
            if (! $carpetacliente->course || $request->input('course') !== $carpetacliente->course->file_name) {
                if ($carpetacliente->course) {
                    $carpetacliente->course->delete();
                }
                $carpetacliente->addMedia(storage_path('tmp/uploads/' . basename($request->input('course'))))->toMediaCollection('course');
            }
        } elseif ($carpetacliente->course) {
            $carpetacliente->course->delete();
        }

        return (new CarpetaclienteResource($carpetacliente))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpetacliente->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
