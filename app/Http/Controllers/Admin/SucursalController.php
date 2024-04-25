<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySucursalRequest;
use App\Http\Requests\StoreSucursalRequest;
use App\Http\Requests\UpdateSucursalRequest;
use App\Models\Empresa;
use App\Models\Sucursal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SucursalController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('sucursal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Sucursal::with(['empresa'])->select(sprintf('%s.*', (new Sucursal)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'sucursal_show';
                $editGate      = 'sucursal_edit';
                $deleteGate    = 'sucursal_delete';
                $crudRoutePart = 'sucursals';

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
            $table->editColumn('nombre', function ($row) {
                return $row->nombre ? $row->nombre : '';
            });
            $table->editColumn('direccion_sucursal', function ($row) {
                return $row->direccion_sucursal ? $row->direccion_sucursal : '';
            });
           /* $table->editColumn('comuna', function ($row) {
                return $row->comuna ? Sucursal::COMUNA_SELECT[$row->comuna] : '';
            });
            $table->editColumn('region', function ($row) {
                return $row->region ? Sucursal::REGION_SELECT[$row->region] : '';
            });*/
            $table->addColumn('empresa_razon_social', function ($row) {
                return $row->empresa ? $row->empresa->razon_social : '';
            });

            $table->editColumn('empresa.rut', function ($row) {
                return $row->empresa ? (is_string($row->empresa) ? $row->empresa : $row->empresa->rut) : '';
            });
            $table->editColumn('empresa.estado', function ($row) {
                return $row->empresa ? (is_string($row->empresa) ? $row->empresa : $row->empresa->estado) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'empresa']);

            return $table->make(true);
        }

        $empresas = Empresa::orderBy('nombe_de_fantasia', 'asc')->get();

        return view('admin.sucursals.index', compact('empresas'));
    }

    public function create()
    {
        abort_if(Gate::denies('sucursal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::Orderby('razon_social')->pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.sucursals.create', compact('empresas'));
    }

    public function store(StoreSucursalRequest $request)
    {
        $sucursal = Sucursal::create($request->all());

        return redirect()->route('admin.sucursals.index');
    }

    public function edit(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::Orderby('razon_social')->pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursal->load('empresa');

        return view('admin.sucursals.edit', compact('empresas', 'sucursal'));
    }

    public function update(UpdateSucursalRequest $request, Sucursal $sucursal)
    {
        $sucursal->update($request->all());

        return redirect()->route('admin.sucursals.index');
    }

    public function show(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sucursal->load('empresa', 'sucursalProyectos', 'sucursalUsers');

        return view('admin.sucursals.show', compact('sucursal'));
    }

    public function destroy(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sucursal->delete();

        return back();
    }

    public function massDestroy(MassDestroySucursalRequest $request)
    {
        $sucursals = Sucursal::find(request('ids'));

        foreach ($sucursals as $sucursal) {
            $sucursal->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
