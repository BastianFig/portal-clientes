<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasecontableRequest;
use App\Http\Requests\StoreFasecontableRequest;
use App\Http\Requests\UpdateFasecontableRequest;
use App\Models\Fasecontable;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\SubirArchivoContable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

class FasecontableController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fasecontable_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecontables = Fasecontable::with(['id_proyecto', 'media'])->get();

        return view('frontend.fasecontables.index', compact('fasecontables'));
    }

    public function create()
    {
        abort_if(Gate::denies('fasecontable_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.fasecontables.create', compact('id_proyectos'));
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

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fasecontable->id]);
        }

        return redirect()->route('frontend.fasecontables.index');
    }

    public function edit(Fasecontable $fasecontable)
    {
        abort_if(Gate::denies('fasecontable_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasecontable->load('id_proyecto');

        return view('frontend.fasecontables.edit', compact('fasecontable', 'id_proyectos'));
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

        return redirect()->route('frontend.fasecontables.index');
    }

    public function show(Fasecontable $fasecontable)
    {
        abort_if(Gate::denies('fasecontable_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecontable->load('id_proyecto');

        return view('frontend.fasecontables.show', compact('fasecontable'));
    }

    public function destroy(Fasecontable $fasecontable)
    {
        abort_if(Gate::denies('fasecontable_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecontable->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasecontableRequest $request)
    {
        $fasecontables = Fasecontable::find(request('ids'));

        foreach ($fasecontables as $fasecontable) {
            $fasecontable->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fasecontable_create') && Gate::denies('fasecontable_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fasecontable();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
