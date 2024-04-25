<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFasecomercialproyectoRequest;
use App\Http\Requests\StoreFasecomercialproyectoRequest;
use App\Http\Requests\UpdateFasecomercialproyectoRequest;
use App\Models\Fasecomercialproyecto;
use App\Models\Proyecto;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FasecomercialproyectoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('fasecomercialproyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Fasecomercialproyecto::with(['id_proyecto'])->select(sprintf('%s.*', (new Fasecomercialproyecto)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fasecomercialproyecto_show';
                $editGate      = 'fasecomercialproyecto_edit';
                $deleteGate    = 'fasecomercialproyecto_delete';
                $crudRoutePart = 'fasecomercialproyectos';

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
            $table->editColumn('nota_venta', function ($row) {
                return $row->nota_venta ? '<a href="' . $row->nota_venta->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('id_proyecto_nombre_proyecto', function ($row) {
                return $row->id_proyecto ? $row->id_proyecto->nombre_proyecto : '';
            });

            $table->editColumn('estado', function ($row) {
                return $row->estado ? $row->estado : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'nota_venta', 'id_proyecto']);

            return $table->make(true);
        }

        return view('admin.fasecomercialproyectos.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fasecomercialproyecto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.fasecomercialproyectos.create', compact('id_proyectos'));
    }

    public function store(StoreFasecomercialproyectoRequest $request)
    {
        $fasecomercialproyecto = Fasecomercialproyecto::create($request->all());

        if ($request->input('nota_venta', false)) {
            $fasecomercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fasecomercialproyecto->id]);
        }

        return redirect()->route('admin.fasecomercialproyectos.index');
    }

    public function edit(Fasecomercialproyecto $fasecomercialproyecto)
    {
        abort_if(Gate::denies('fasecomercialproyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $fasecomercialproyecto->load('id_proyecto');

        return view('admin.fasecomercialproyectos.edit', compact('fasecomercialproyecto', 'id_proyectos'));
    }

    public function update(UpdateFasecomercialproyectoRequest $request, Fasecomercialproyecto $fasecomercialproyecto)
    {
        $fasecomercialproyecto->update($request->all());

        if ($request->input('nota_venta', false)) {
            if (! $fasecomercialproyecto->nota_venta || $request->input('nota_venta') !== $fasecomercialproyecto->nota_venta->file_name) {
                if ($fasecomercialproyecto->nota_venta) {
                    $fasecomercialproyecto->nota_venta->delete();
                }
                $fasecomercialproyecto->addMedia(storage_path('tmp/uploads/' . basename($request->input('nota_venta'))))->toMediaCollection('nota_venta');
            }
        } elseif ($fasecomercialproyecto->nota_venta) {
            $fasecomercialproyecto->nota_venta->delete();
        }

        return redirect()->route('admin.fasecomercialproyectos.index');
    }

    public function show(Fasecomercialproyecto $fasecomercialproyecto)
    {
        abort_if(Gate::denies('fasecomercialproyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercialproyecto->load('id_proyecto', 'idFaseComercialCarpetaclientes');

        return view('admin.fasecomercialproyectos.show', compact('fasecomercialproyecto'));
    }

    public function destroy(Fasecomercialproyecto $fasecomercialproyecto)
    {
        abort_if(Gate::denies('fasecomercialproyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasecomercialproyecto->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasecomercialproyectoRequest $request)
    {
        $fasecomercialproyectos = Fasecomercialproyecto::find(request('ids'));

        foreach ($fasecomercialproyectos as $fasecomercialproyecto) {
            $fasecomercialproyecto->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fasecomercialproyecto_create') && Gate::denies('fasecomercialproyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fasecomercialproyecto();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
