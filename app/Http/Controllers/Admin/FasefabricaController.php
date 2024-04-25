<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasefabricaRequest;
use App\Http\Requests\StoreFasefabricaRequest;
use App\Http\Requests\UpdateFasefabricaRequest;
use App\Models\Fasefabrica;
use App\Models\Fasecomercial;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FasefabricaController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fasefabrica_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fasefabrica::with(['id_proyecto'])->select(sprintf('%s.*', (new Fasefabrica)->table));
            
            $table = Datatables::of($query);


            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fasefabrica_show';
                $editGate      = 'fasefabrica_edit';
                $deleteGate    = 'fasefabrica_delete';
                $crudRoutePart = 'fasefabricas';

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
            $table->editColumn('aprobacion_course', function ($row) {
                return $row->aprobacion_course ? Fasefabrica::APROBACION_COURSE_SELECT[$row->aprobacion_course] : '';
            });
            $table->editColumn('oc_proveedores', function ($row) {
                if (!$row->oc_proveedores) {
                    return '';
                }
                $links = [];
                foreach ($row->oc_proveedores as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' .str_replace('_', ' ', $media->file_name). '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('estado_produccion', function ($row) {
                return $row->estado_produccion ? Fasefabrica::ESTADO_PRODUCCION_SELECT[$row->estado_produccion] : '';
            });

            $table->editColumn('galeria_estado_entrega', function ($row) {
                if (!$row->galeria_estado_entrega) {
                    return '';
                }
                $links = [];
                foreach ($row->galeria_estado_entrega as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->addColumn('id_proyecto_nombre_proyecto', function ($row) {
                return $row->id_proyecto ? $row->id_proyecto->nombre_proyecto : '';
            });

            $table->editColumn('estado', function ($row) {
                return $row->estado ? $row->estado : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'oc_proveedores', 'galeria_estado_entrega', 'id_proyecto']);

            return $table->make(true);
        }
        //error_log($request);
        return view('admin.fasefabricas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fasefabrica_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fasefabricas.create', compact('id_proyectos'));
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

        return redirect()->route('admin.fasefabricas.index');
    }

    public function edit(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasefabrica->load('id_proyecto');

        return view('admin.fasefabricas.edit', compact('fasefabrica', 'id_proyectos'));
    }

    public function update(UpdateFasefabricaRequest $request, Fasefabrica $fasefabrica)
    {
        $fasefabrica->update($request->all());

        if (count($fasefabrica->oc_proveedores) > 0) {
            foreach ($fasefabrica->oc_proveedores as $media) {
                if (!in_array($media->file_name, $request->input('oc_proveedores', []))) {
                    $media->delete();
                }
            }
        }
        $media = $fasefabrica->oc_proveedores->pluck('file_name')->toArray();
        foreach ($request->input('oc_proveedores', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('oc_proveedores');
            }
        }

        if (count($fasefabrica->galeria_estado_entrega) > 0) {
            foreach ($fasefabrica->galeria_estado_entrega as $media) {
                if (!in_array($media->file_name, $request->input('galeria_estado_entrega', []))) {
                    $media->delete();
                }
            }
        }
        $media = $fasefabrica->galeria_estado_entrega->pluck('file_name')->toArray();
        foreach ($request->input('galeria_estado_entrega', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $fasefabrica->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('galeria_estado_entrega');
            }
        }

        return redirect()->route('admin.fasefabricas.index');
    }

    public function show(Fasefabrica $fasefabrica)
    {
        abort_if(Gate::denies('fasefabrica_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasefabrica->load('id_proyecto');

        return view('admin.fasefabricas.show', compact('fasefabrica'));
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
