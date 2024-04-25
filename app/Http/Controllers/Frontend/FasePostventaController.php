<?php

namespace App\Http\Controllers\Frontend;

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

class FasePostventaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('fase_postventum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasePostventa = FasePostventum::with(['encuesta', 'ticket', 'id_proyecto', 'id_usuarios'])->get();

        return view('frontend.fasePostventa.index', compact('fasePostventa'));
    }

    public function create()
    {
        abort_if(Gate::denies('fase_postventum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestas = Encuestum::pluck('observacion', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tickets = Ticket::pluck('asunto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios = User::pluck('name', 'id');

        return view('frontend.fasePostventa.create', compact('encuestas', 'id_proyectos', 'id_usuarios', 'tickets'));
    }

    public function store(StoreFasePostventumRequest $request)
    {
        $fasePostventum = FasePostventum::create($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return redirect()->route('frontend.fase-postventa.index');
    }

    public function edit(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuestas = Encuestum::pluck('observacion', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tickets = Ticket::pluck('asunto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios = User::pluck('name', 'id');

        $fasePostventum->load('encuesta', 'ticket', 'id_proyecto', 'id_usuarios');

        return view('frontend.fasePostventa.edit', compact('encuestas', 'fasePostventum', 'id_proyectos', 'id_usuarios', 'tickets'));
    }

    public function update(UpdateFasePostventumRequest $request, FasePostventum $fasePostventum)
    {
        $fasePostventum->update($request->all());
        $fasePostventum->id_usuarios()->sync($request->input('id_usuarios', []));

        return redirect()->route('frontend.fase-postventa.index');
    }

    public function show(FasePostventum $fasePostventum)
    {
        abort_if(Gate::denies('fase_postventum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fasePostventum->load('encuesta', 'ticket', 'id_proyecto', 'id_usuarios');

        return view('frontend.fasePostventa.show', compact('fasePostventum'));
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
