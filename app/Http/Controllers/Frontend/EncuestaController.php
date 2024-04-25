<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEncuestumRequest;
use App\Http\Requests\StoreEncuestumRequest;
use App\Http\Requests\UpdateEncuestumRequest;
use App\Models\Encuestum;
use App\Models\Empresa;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\CompletaEncuesta;

class EncuestaController extends Controller
{

    public function Responder($id_proyecto){

        $userID = Auth::id();
        $user = User::find($userID);
        $empresa_user = Empresa::find($user->empresa_id);

        return view('frontend.encuesta.responder', compact('id_proyecto','userID', 'user', 'empresa_user'));
    }

    public function index()
    {
        abort_if(Gate::denies('encuestum_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $encuesta = Encuestum::all();

        return view('frontend.encuesta.index', compact('encuesta'));
    }

    public function create($id_proyecto)
    {
        abort_if(Gate::denies('encuestum_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $empresas = Empresa::pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');
        $userID = Auth::id();
        $user = User::find($userID);
        $empresa_user = Empresa::find($user->empresa_id);

        return view('frontend.encuesta.create', compact('empresas', 'user', 'userID', 'empresa_user'));
    }

    public function store(StoreEncuestumRequest $request)
    {
        $encuestum = Encuestum::create($request->all());
        $encuestaId = $encuestum->id;
        $proyecto =  DB::table('proyectos')->where('id', $request->proyecto_id)->update(['encuesta_id' => $encuestum->id]);
        
        $proyecto_2 = Proyecto::find($request->proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
        $vendedorID = $proyecto_2->id_vendedor;
        //dd($vendedorID);
        if ($proyecto) {
            $id_proyecto = $proyecto_2->id;
            $nombre_proyecto = $proyecto_2->nombre_proyecto;
            if ($vendedorID) {
                $user = User::find($vendedorID);
                $email = $user->email;
                //$email = 'j.vergaracajas@gmail.com';
                //dd($email);
                $name = $user->name;

                if ($email) {
                    Mail::to($email)->send(new CompletaEncuesta($nombre_proyecto, $name, $id_proyecto, $encuestaId));
                } else {
                }
            }
        }


        return redirect()->route('frontend.home');
    }

    public function edit(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.encuesta.edit', compact('encuestum'));
    }

    public function update(UpdateEncuestumRequest $request, Encuestum $encuestum)
    {
        $encuestum->update($request->all());

        return redirect()->route('frontend.encuesta.index');
    }

    public function show(Encuestum $encuestum)
    {
        abort_if(Gate::denies('encuestum_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.encuesta.show', compact('encuestum'));
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