<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasedespachoRequest;
use App\Http\Requests\StoreFasedespachoRequest;
use App\Http\Requests\UpdateFasedespachoRequest;
use App\Models\Fasedespacho;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FasedespachoController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasedespacho_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasedespachos = Fasedespacho::with(['id_proyecto', 'media'])->get();

        return view('frontend.fasedespachos.index', compact('fasedespachos'));
    }

    public function create()
    {
        abort_if(Gate::denies('fasedespacho_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fasedespachos.create', compact('id_proyectos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fasedespacho->id]);
        }

        return redirect()->route('frontend.fasedespachos.index');
    }

    public function edit(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasedespacho->load('id_proyecto');

        return view('frontend.fasedespachos.edit', compact('fasedespacho', 'id_proyectos'));
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

        return redirect()->route('frontend.fasedespachos.index');
    }

    public function show(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasedespacho->load('id_proyecto');

        return view('frontend.fasedespachos.show', compact('fasedespacho'));
    }

    public function destroy(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasedespacho->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasedespachoRequest $request)
    {
        $fasedespachos = Fasedespacho::find(request('ids'));

        foreach ($fasedespachos as $fasedespacho) {
            $fasedespacho->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fasedespacho_create') && Gate::denies('fasedespacho_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fasedespacho();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
