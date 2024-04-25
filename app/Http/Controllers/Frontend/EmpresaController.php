<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmpresaRequest;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Empresa;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresaController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('empresa_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $empresas = Empresa::all();

        return view('frontend.empresas.index', compact('empresas'));
    }

    public function create()
    {
        abort_if(Gate::denies('empresa_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.empresas.create');
    }

    public function store(StoreEmpresaRequest $request)
    {
        $empresa = Empresa::create($request->all());

        return redirect()->route('frontend.empresas.index');
    }

    public function edit(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.empresas.edit', compact('empresa'));
    }

    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        $empresa->update($request->all());

        return redirect()->route('frontend.empresas.index');
    }

    public function show(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.empresas.show', compact('empresa'));
    }

    public function destroy(Empresa $empresa)
    {
        abort_if(Gate::denies('empresa_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
}
