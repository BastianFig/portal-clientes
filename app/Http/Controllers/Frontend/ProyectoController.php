<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Traits\MediaUploadingTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProyectoRequest;
use App\Http\Requests\StoreProyectoRequest;
use App\Http\Requests\UpdateProyectoRequest;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Sucursal;
use App\Models\Facturacion;
use App\Models\FaseDiseno;
use App\Models\Fasecomercial;
use App\Models\Fasecomercialproyecto;
use App\Models\Fasecontable;
use App\Models\Fasedespacho;
use App\Models\Fasefabrica;
use App\Models\FasePostventum;
use App\Models\Carpetacliente;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Mail\EnvioDatosFacturacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Auth;

class ProyectoController extends Controller
{
    use MediaUploadingTrait;

    public function aceptaConforme(Request $request)
    {
        $faseAcuerdoComercial = Fasecomercialproyecto::find($request->id_fasecomercialproyectos);
        $faseAcuerdoComercial->acepta = $request->acepta;
        $faseAcuerdoComercial->firma = $request->dataUrl;
        $faseAcuerdoComercial->save();


        return back()->with('success', 'Se han aceptado las condiciones del acuerdo comercial.');
        //return response()->json(['response' => $request->id_fasecomercialproyectos]);

    }

    public function confirmarHorario(Request $request)
    {
        $faseDespacho = Fasedespacho::find($request->idproyecto);
        $faseDespacho->horario = $request->horarioDespacho;
        $faseDespacho->confirma_horario = $request->confirma_horario;
        $faseDespacho->save();
        //dd($request);
        return back()->with('success', 'Horario seleccionado correctamente.');
    }

    public function storeFacturacion(Request $request)
    {

        $current_timestamp = Carbon::now()->toDateTimeString();

        //dd($request);
        $facturacion = Facturacion::create($request->all());

        $proyecto = Proyecto::find($request->id_proyecto);
        $proyecto->facturacion_id = $facturacion->id;
        $proyecto->save();

        if ($proyecto) {
            $nombre_proyecto = $proyecto->nombre_proyecto;
            $razon_social = $request->razon_social;
            $rut = $request->rut;
            $giro = $request->giro;
            $direccion = $request->direccion;
            $email = $request->email;
            $nombre_contacto = $request->nombre_contacto;
            $direccion_despacho = $request->direccion_despacho;
            $nombre_despacho = $request->nombre_despacho;
            $telefono_despacho = $request->telefono_despacho;
            $comentario = $request->comentario;

            //Mail::to('marcela.mendez@ohffice.cl')->send(new EnvioDatosFacturacion($razon_social, $rut, $giro, $direccion, $email, $nombre_contacto, $direccion_despacho, $nombre_despacho, $telefono_despacho, $nombre_proyecto, $comentario));       
        }

        //Proyecto::where('id',$request->proyecto_id)->update(['facturacion_id'=>$id]);
        // hay que hacer el update para guardar la facturacion_id en el proyecto.
        return back()->with('success', 'Datos guardados correctamente!!!');
    }



    public function index()
    {
        $id_vendedor = Auth::user()->id;
        abort_if(Gate::denies('proyecto_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

       // $proyectos = Proyecto::with(['id_cliente', 'id_usuarios_clientes', 'sucursal'])->where('id_vendedor', $id_vendedor)->get();
       $proyectos = Proyecto::with(['id_cliente', 'sucursal'])
    ->join('proyecto_user', 'proyectos.id', '=', 'proyecto_user.proyecto_id')
    ->where('proyecto_user.user_id', $id_vendedor)
    ->get();

        $empresas = Empresa::get();

        $users = User::get();

        $sucursals = Sucursal::get();

        return view('frontend.proyectos.index', compact('empresas', 'proyectos', 'sucursals', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('proyecto_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_clientes = Empresa::pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios_clientes = User::pluck('name', 'id');

        $sucursals = Sucursal::pluck('nombre', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.proyectos.create', compact('id_clientes', 'id_usuarios_clientes', 'sucursals'));
    }

    public function store(StoreProyectoRequest $request)
    {
        $proyecto = Proyecto::create($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        return redirect()->route('frontend.proyectos.index');
    }

    public function edit(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id_clientes = Empresa::pluck('nombe_de_fantasia', 'id')->prepend(trans('global.pleaseSelect'), '');

        $id_usuarios_clientes = User::pluck('name', 'id');

        $sucursals = Sucursal::pluck('nombre', 'id')->prepend(trans('global.pleaseSelect'), '');

        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal');

        return view('frontend.proyectos.edit', compact('id_clientes', 'id_usuarios_clientes', 'proyecto', 'sucursals'));
    }

    public function update(UpdateProyectoRequest $request, Proyecto $proyecto)
    {
        $proyecto->update($request->all());
        $proyecto->id_usuarios_clientes()->sync($request->input('id_usuarios_clientes', []));

        return redirect()->route('frontend.proyectos.index');
    }

    public function show(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal', 'fasediseno', 'fasecomercial', 'fasecomercialproyecto', 'fasecontable', 'fasedespacho', 'fasefabrica', 'fasepostventa', 'carpetacliente', 'facturacion');
        /// $media = $proyecto->getMedia();
        /// $proyecto->load('id_cliente', 'id_usuarios_clientes', 'sucursal');
        $proyectos = Proyecto::findOrFail($proyecto->id); // Suponiendo que tengas un modelo Proyecto

        $empresa = Empresa::findOrFail($proyectos->id_cliente_id);
        $vendedor = User::findOrFail($proyectos->id_vendedor);
        //dd($vendedor);
        return view('frontend.proyectos.show', compact('proyecto','empresa','vendedor'));
    }

    public function destroy(Proyecto $proyecto)
    {
        abort_if(Gate::denies('proyecto_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyecto->delete();

        return back();
    }

    public function massDestroy(MassDestroyProyectoRequest $request)
    {
        $proyectos = Proyecto::find(request('ids'));

        foreach ($proyectos as $proyecto) {
            $proyecto->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
