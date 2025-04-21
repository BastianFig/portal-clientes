<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEncuestumRequest;
use App\Http\Requests\StoreEncuestumRequest;
use App\Http\Requests\UpdateEncuestumRequest;
use App\Models\Encuestum;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Sucursal;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class EncuestaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('encuestum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Encuestum::with(['empresa', 'proyecto'])->select(sprintf('%s.*', (new Encuestum)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'encuestum_show';
                $editGate = 'encuestum_edit';
                $deleteGate = 'encuestum_delete';
                $crudRoutePart = 'encuesta';

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
            $table->editColumn('observacion', function ($row) {
                return $row->observacion ? $row->observacion : '';
            });
            $table->editColumn('user_id', function ($row) {
                return $row->user_id ? $row->user_id : '';
            });
            $table->editColumn('proyecto_id', function ($row) {
                return $row->proyecto_id ? $row->proyecto_id : '';
            });
            $table->addColumn('proyecto.nombre_proyecto', function ($row) {
                return $row->proyecto ? $row->proyecto->nombre_proyecto : '';
            });

            $table->addColumn('empresa.razon_social', function ($row) {
                return $row->empresa ? $row->empresa->razon_social : '';
            });

            $table->addColumn('nombre_encuestado', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('rating', function ($row) {
                return $row->rating ?? 0;
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.encuesta.index');
    }

    public function create()
    {
        abort_if(Gate::denies('encuestum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');
        $userID = Auth::id();
        $user = User::find($userID);
        $empresa_user = Empresa::find($user->empresa_id);
        return view('admin.encuesta.create', compact('empresas', 'user', 'userID', 'empresa_user'));
    }

    public function store(StoreEncuestumRequest $request)
    {
        $encuestum = Encuestum::create($request->all());


        return redirect()->route('admin.encuesta.index');
    }

    public function edit(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.encuesta.edit', compact('encuestum'));
    }

    public function update(UpdateEncuestumRequest $request, Encuestum $encuestum)
    {
        $encuestum->update($request->all());

        return redirect()->route('admin.encuesta.index');
    }

    public function show(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $userID = Auth::id();
        $user = User::find($userID);
        $empresa_user = Empresa::find($user->empresa_id);

        return view('admin.encuesta.show', compact('encuestum', 'userID', 'user', 'empresa_user'));
    }

    public function destroy(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestum->delete();

        return back();
    }

    public function massDestroy(MassDestroyEncuestumRequest $request)
    {
        $encuesta = Encuestum::find(request('ids'));

        foreach ($encuesta as $encuestum) {
            $encuestum->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
