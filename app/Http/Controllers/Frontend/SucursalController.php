<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySucursalRequest;
use App\Http\Requests\StoreSucursalRequest;
use App\Http\Requests\UpdateSucursalRequest;
use App\Models\Empresa;
use App\Models\Sucursal;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SucursalController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sucursal_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sucursals = Sucursal::with(['empresa'])->get();

        $empresas = Empresa::get();

        return view('frontend.sucursals.index', compact('empresas', 'sucursals'));
    }

    public function create()
    {
        abort_if(Gate::denies('sucursal_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.sucursals.create', compact('empresas'));
    }

    public function store(StoreSucursalRequest $request)
    {
        $sucursal = Sucursal::create($request->all());

        return redirect()->route('frontend.sucursals.index');
    }

    public function edit(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::pluck('razon_social', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sucursal->load('empresa');

        return view('frontend.sucursals.edit', compact('empresas', 'sucursal'));
    }

    public function update(UpdateSucursalRequest $request, Sucursal $sucursal)
    {
        $sucursal->update($request->all());

        return redirect()->route('frontend.sucursals.index');
    }

    public function show(Sucursal $sucursal)
    {
        abort_if(Gate::denies('sucursal_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sucursal->load('empresa');

        return view('frontend.sucursals.show', compact('sucursal'));
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
