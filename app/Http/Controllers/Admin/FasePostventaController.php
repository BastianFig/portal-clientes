<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFasePostventumRequest;
use App\Http\Requests\StoreFasePostventumRequest;
use App\Http\Requests\UpdateFasePostventumRequest;
use App\Models\Encuestum;
use App\Models\FasePostventum;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class FasePostventaController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('fase_postventum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = FasePostventum::with(['encuesta', 'ticket', 'id_proyecto', 'id_usuarios'])->select(sprintf('%s.*', (new FasePostventum)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'fase_postventum_show';
                $editGate      = 'fase_postventum_edit';
                $deleteGate    = 'fase_postventum_delete';
                $crudRoutePart = 'fase-postventa';

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
            $table->addColumn('encuesta_observacion', function ($row) {
                return $row->encuesta ? $row->encuesta->observacion : '';
            });

            $table->addColumn('ticket_asunto', function ($row) {
                return $row->ticket ? $row->ticket->asunto : '';
            });

            $table->addColumn('id_proyecto_nombre_proyecto', function ($row) {
                return $row->id_proyecto ? $row->id_proyecto->nombre_proyecto : '';
            });

            $table->editColumn('id_usuario', function ($row) {
                $labels = [];
                foreach ($row->id_usuarios as $id_usuario) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $id_usuario->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('estado', function ($row) {
                return $row->estado ? $row->estado : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'encuesta', 'ticket', 'id_proyecto', 'id_usuario']);

            return $table->make(true);
        }

        return view('admin.fasePostventa.index');
    }

    public function create()
    {
        abort_if(Gate::denies('fase_postventum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestas = Encuestum::pluck('observacion', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tickets = Ticket::pluck('asunto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios = User::pluck('name', 'id');

        return view('admin.fasePostventa.create', compact('encuestas', 'id_proyectos', 'id_usuarios', 'tickets'));
    }

    public function store(StoreFasePostventumRequest $request)
    {
        $fasePostventum = FasePostventum::create($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return redirect()->route('admin.fase-postventa.index');
    }

    public function edit(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestas = Encuestum::pluck('observacion', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tickets = Ticket::pluck('asunto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios = User::pluck('name', 'id');

        $fasePostventum->load('encuesta', 'ticket', 'id_proyecto', 'id_usuarios');

        return view('admin.fasePostventa.edit', compact('encuestas', 'fasePostventum', 'id_proyectos', 'id_usuarios', 'tickets'));
    }

    public function update(UpdateFasePostventumRequest $request, FasePostventum $fasePostventum)
    {
        $fasePostventum->update($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return redirect()->route('admin.fase-postventa.index');
    }

    public function show(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasePostventum->load('encuesta', 'ticket', 'id_proyecto', 'id_usuarios');

        return view('admin.fasePostventa.show', compact('fasePostventum'));
    }

    public function destroy(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasePostventum->delete();

        return back();
    }

    public function massDestroy(MassDestroyFasePostventumRequest $request)
    {
        $fasePostventa = FasePostventum::find(request('ids'));

        foreach ($fasePostventa as $fasePostventum) {
            $fasePostventum->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
