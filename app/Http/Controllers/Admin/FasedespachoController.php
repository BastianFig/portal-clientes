<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class FasedespachoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fasedespacho_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fasedespacho::with(['id_proyecto'])->select(sprintf('%s.*', (new Fasedespacho)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fasedespacho_show';
                $editGate      = 'fasedespacho_edit';
                $deleteGate    = 'fasedespacho_delete';
                $crudRoutePart = 'fasedespachos';

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
           /* $table->editColumn('guia_despacho', function ($row) {
                return $row->guia_despacho ? '<a href="' . $row->guia_despacho->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });*/
            
            $table->editColumn('guia_despacho', function ($row) {
                if (!$row->guia_despacho) {
                    return '';
                }
                $links = [];
                foreach ($row->guia_despacho as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' .str_replace('_', ' ', $media->file_name). '</a>';
                }

                return implode(', ', $links);
            });
            

            $table->editColumn('estado_instalacion', function ($row) {
                return $row->estado_instalacion ? Fasedespacho::ESTADO_INSTALACION_SELECT[$row->estado_instalacion] : '';
            });
            $table->editColumn('recibe_conforme', function ($row) {
                return $row->recibe_conforme ? Fasedespacho::RECIBE_CONFORME_SELECT[$row->recibe_conforme] : '';
            });
            $table->editColumn('galeria_estado_muebles', function ($row) {
                if (! $row->galeria_estado_muebles) {
                    return '';
                }
                $links = [];
                foreach ($row->galeria_estado_muebles as $media) {
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

            $table->rawColumns(['actions', 'placeholder', 'guia_despacho', 'galeria_estado_muebles', 'id_proyecto']);

            return $table->make(true);
        }

        return view('admin.fasedespachos.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fasedespacho_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fasedespachos.create', compact('id_proyectos'));
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

        return redirect()->route('admin.fasedespachos.index');
    }

    public function edit(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasedespacho->load('id_proyecto');

        return view('admin.fasedespachos.edit', compact('fasedespacho', 'id_proyectos'));
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

        return redirect()->route('admin.fasedespachos.index');
    }

    public function show(Fasedespacho $fasedespacho)
    {
        abort_if(Gate::denies('fasedespacho_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasedespacho->load('id_proyecto');

        return view('admin.fasedespachos.show', compact('fasedespacho'));
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
