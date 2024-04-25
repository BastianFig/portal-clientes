<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmpresaRequest;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Empresa;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class EmpresaController extends Controller
{
    use MediaUploadingTrait;
    
    public function index(Request $request)
    {
        abort_if(Gate::denies('empresa_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Empresa::query()->select(sprintf('%s.*', (new Empresa)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'empresa_show';
                $editGate      = 'empresa_edit';
                $deleteGate    = 'empresa_delete';
                $crudRoutePart = 'empresas';

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
            $table->editColumn('direccion', function ($row) {
                return $row->direccion ? $row->direccion : '';
            });
            /*$table->editColumn('comuna', function ($row) {
                return $row->comuna ? Empresa::COMUNA_SELECT[$row->comuna] : '';
            });
            $table->editColumn('antiguedad_empresa', function ($row) {
                return $row->region ? Empresa::ANTIGUEDAD_EMPRESA[$row->antiguedad_empresa] : '';
            });*/
            $table->editColumn('rut', function ($row) {
                return $row->rut ? $row->rut : '';
            });
            $table->editColumn('razon_social', function ($row) {
                return $row->razon_social ? $row->razon_social : '';
            });
            $table->editColumn('nombe_de_fantasia', function ($row) {
                return $row->nombe_de_fantasia ? $row->nombe_de_fantasia : '';
            });
            $table->editColumn('rubro', function ($row) {
                return $row->rubro ? $row->rubro : '';
            });
            $table->editColumn('estado', function ($row) {
                return $row->estado ? Empresa::ESTADO_SELECT[$row->estado] : '';
            });
            $table->editColumn('tipo_empresa', function ($row) {
                return $row->tipo_empresa ? Empresa::TIPO_EMPRESA_SELECT[$row->tipo_empresa] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.empresas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('empresa_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empresas.create');
    }

    public function store(StoreEmpresaRequest $request)
    {
        $empresa = Empresa::create($request->all());
        if ($request->input('logo', false)) {
            $empresa->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $empresa->id]);
        }

        return redirect()->route('admin.empresas.index');
    }

    public function edit(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.empresas.edit', compact('empresa'));
    }

    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->all());

        if ($request->input('logo', false)) {
            if (! $empresa->logo || $request->input('logo') !== $empresa->logo->file_name) {
                if ($empresa->logo) {
                    $empresa->logo->delete();
                }
                $empresa->addMedia(storage_path('tmp/uploads/' . basename($request->input('logo'))))->toMediaCollection('logo');
            }
        } elseif ($empresa->logo) {
            $empresa->logo->delete();
        }

        return redirect()->route('admin.empresas.index');
    }

    public function show(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresa->load('empresaSucursals', 'empresaUsers', 'idClienteProyectos');

        return view('admin.empresas.show', compact('empresa'));
    }

    public function destroy(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($empresa->rut =="77.570.810-7"){
            $messages_aux ="Ohffice Spa no se puede eliminar";
            return back()->withErrors($messages_aux);
        }
        $empresa->delete();
        return back();
    }

    public function massDestroy(MassDestroyEmpresaRequest $request)
    {
        $empresas = Empresa::find(request('ids'));

        foreach ($empresas as $empresa) {
            $empresa->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('empresa_create') && Gate::denies('empresa_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Empresa();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
