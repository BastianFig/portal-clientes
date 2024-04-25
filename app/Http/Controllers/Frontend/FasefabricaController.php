<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasefabricaRequest;
use App\Http\Requests\StoreFasefabricaRequest;
use App\Http\Requests\UpdateFasefabricaRequest;
use App\Models\Fasefabrica;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FasefabricaController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasefabrica_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasefabricas = Fasefabrica::with(['id_proyecto', 'media'])->get();

        return view('frontend.fasefabricas.index', compact('fasefabricas'));
    }

    public function create()
    {
        abort_if(Gate::denies('fasefabrica_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fasefabricas.create', compact('id_proyectos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fasefabrica->id]);
        }

        return redirect()->route('frontend.fasefabricas.index');
    }

    public function edit(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasefabrica->load('id_proyecto');

        return view('frontend.fasefabricas.edit', compact('fasefabrica', 'id_proyectos'));
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

        return redirect()->route('frontend.fasefabricas.index');
    }

    public function show(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasefabrica->load('id_proyecto');

        return view('frontend.fasefabricas.show', compact('fasefabrica'));
    }

    public function destroy(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasefabrica->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasefabricaRequest $request)
    {
        $fasefabricas = Fasefabrica::find(request('ids'));

        foreach ($fasefabricas as $fasefabrica) {
            $fasefabrica->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fasefabrica_create') && Gate::denies('fasefabrica_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fasefabrica();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
