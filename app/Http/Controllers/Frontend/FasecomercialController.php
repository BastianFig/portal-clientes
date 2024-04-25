<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasecomercialRequest;
use App\Http\Requests\StoreFasecomercialRequest;
use App\Http\Requests\UpdateFasecomercialRequest;
use App\Models\Fasecomercial;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FasecomercialController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasecomercial_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercials = Fasecomercial::with(['id_proyecto', 'media'])->get();

        return view('frontend.fasecomercials.index', compact('fasecomercials'));
    }

    public function create()
    {
        abort_if(Gate::denies('fasecomercial_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fasecomercials.create', compact('id_proyectos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fasecomercial->id]);
        }

        return redirect()->route('frontend.fasecomercials.index');
    }

    public function edit(Fasecomercial $fasecomercial)
    {
        abort_if(Gate::denies('fasecomercial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasecomercial->load('id_proyecto');

        return view('frontend.fasecomercials.edit', compact('fasecomercial', 'id_proyectos'));
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

        return redirect()->route('frontend.fasecomercials.index');
    }

    public function show(Fasecomercial $fasecomercial)
    {
        abort_if(Gate::denies('fasecomercial_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercial->load('id_proyecto');

        return view('frontend.fasecomercials.show', compact('fasecomercial'));
    }

    public function destroy(Fasecomercial $fasecomercial)
    {
        abort_if(Gate::denies('fasecomercial_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercial->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasecomercialRequest $request)
    {
        $fasecomercials = Fasecomercial::find(request('ids'));

        foreach ($fasecomercials as $fasecomercial) {
            $fasecomercial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fasecomercial_create') && Gate::denies('fasecomercial_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fasecomercial();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
