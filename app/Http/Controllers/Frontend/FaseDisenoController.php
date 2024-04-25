<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFaseDisenoRequest;
use App\Http\Requests\StoreFaseDisenoRequest;
use App\Http\Requests\UpdateFaseDisenoRequest;
use App\Models\FaseDiseno;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FaseDisenoController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fase_diseno_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faseDisenos = FaseDiseno::with(['id_proyecto', 'media'])->get();

        return view('frontend.faseDisenos.index', compact('faseDisenos'));
    }

    public function create()
    {
        abort_if(Gate::denies('fase_diseno_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.faseDisenos.create', compact('id_proyectos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $faseDiseno->id]);
        }

        return redirect()->route('frontend.fase-disenos.index');
    }

    public function edit(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $faseDiseno->load('id_proyecto');

        return view('frontend.faseDisenos.edit', compact('faseDiseno', 'id_proyectos'));
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

        return redirect()->route('frontend.fase-disenos.index');
    }

    public function show(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faseDiseno->load('id_proyecto');

        return view('frontend.faseDisenos.show', compact('faseDiseno'));
    }

    public function destroy(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faseDiseno->delete();

        return back();
    }

    public function massDestroy(MassDestroyFaseDisenoRequest $request)
    {
        $faseDisenos = FaseDiseno::find(request('ids'));

        foreach ($faseDisenos as $faseDiseno) {
            $faseDiseno->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fase_diseno_create') && Gate::denies('fase_diseno_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FaseDiseno();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
