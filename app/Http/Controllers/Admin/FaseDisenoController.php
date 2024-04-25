<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class FaseDisenoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fase_diseno_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FaseDiseno::with(['id_proyecto'])->select(sprintf('%s.*', (new FaseDiseno)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fase_diseno_show';
                $editGate      = 'fase_diseno_edit';
                $deleteGate    = 'fase_diseno_delete';
                $crudRoutePart = 'fase-disenos';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('descripcion', function ($row) {
                return $row->descripcion ? $row->descripcion : '';
            });
            $table->editColumn('imagenes', function ($row) {
                if (! $row->imagenes) {
                    return '';
                }
                $links = [];
                foreach ($row->imagenes as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('propuesta', function ($row) {
                if (! $row->propuesta) {
                    return '';
                }
                $links = [];
                foreach ($row->propuesta as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('estado', function ($row) {
                return $row->estado ? $row->estado : '';
            });
            $table->addColumn('id_proyecto_nombre_proyecto', function ($row) {
                return $row->id_proyecto ? $row->id_proyecto->nombre_proyecto : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'imagenes', 'propuesta', 'id_proyecto']);

            return $table->make(true);
        }

        return view('admin.faseDisenos.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fase_diseno_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.faseDisenos.create', compact('id_proyectos'));
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

        DB::update('UPDATE proyectos SET id_fasediseno = '.$faseDiseno->id.' WHERE id = '.$request->id_proyecto_id);

        return redirect()->route('admin.fase-disenos.index');
    }


    public function store_proyecto(StoreFaseDisenoRequest $request)
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

        DB::update('UPDATE proyectos SET id_fasediseno = '.$faseDiseno->id.' WHERE id = '.$request->id_proyecto_id);

       // return redirect()->route('admin.fase-disenos.index');
    }

    public function edit(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $faseDiseno->load('id_proyecto');

        return view('admin.faseDisenos.edit', compact('faseDiseno', 'id_proyectos'));
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

        return redirect()->route('admin.fase-disenos.index');
    }

    public function show(FaseDiseno $faseDiseno)
    {
        abort_if(Gate::denies('fase_diseno_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $faseDiseno->load('id_proyecto');

        return view('admin.faseDisenos.show', compact('faseDiseno'));
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
