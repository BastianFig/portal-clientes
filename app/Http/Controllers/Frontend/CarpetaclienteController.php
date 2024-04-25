<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCarpetaclienteRequest;
use App\Http\Requests\StoreCarpetaclienteRequest;
use App\Http\Requests\UpdateCarpetaclienteRequest;
use App\Models\Carpetacliente;
use App\Models\Fasecomercialproyecto;
use Gate;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CarpetaclienteController extends Controller
{
    use MediaUploadingTrait;

    public function index()
{
    abort_if(Gate::denies('carpetacliente_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    // Obtener el ID del vendedor actualmente autenticado
    $idVendedor = Auth::id();

    // Obtener las carpetas de clientes asociadas al vendedor actual
    $carpetaclientes = Carpetacliente::whereHas('proyecto', function ($query) use ($idVendedor) {
        $query->where('id_vendedor', $idVendedor);
    })
    ->with(['id_fase_comercial', 'media'])
    ->get();
    
    return view('frontend.carpetaclientes.index', compact('carpetaclientes'));
}

    public function create()
    {
        abort_if(Gate::denies('carpetacliente_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_fase_comercials = Fasecomercialproyecto::pluck('estado', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.carpetaclientes.create', compact('id_fase_comercials'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $carpetacliente->id]);
        }

        return redirect()->route('frontend.carpetaclientes.index');
    }

    public function edit(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_fase_comercials = Fasecomercialproyecto::pluck('estado', 'id')->prepend(trans('global.pleaseSelect'), '');

        $carpetacliente->load('id_fase_comercial');

        return view('frontend.carpetaclientes.edit', compact('carpetacliente', 'id_fase_comercials'));
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

        return redirect()->route('frontend.carpetaclientes.index');
    }

    public function show(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpetacliente->load('id_fase_comercial');

        return view('frontend.carpetaclientes.show', compact('carpetacliente'));
    }

    public function destroy(Carpetacliente $carpetacliente)
    {
        abort_if(Gate::denies('carpetacliente_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carpetacliente->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarpetaclienteRequest $request)
    {
        $carpetaclientes = Carpetacliente::find(request('ids'));

        foreach ($carpetaclientes as $carpetacliente) {
            $carpetacliente->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('carpetacliente_create') && Gate::denies('carpetacliente_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Carpetacliente();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
