<?php

namespace App\Http\Controllers\Admin;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Sucursal;
use App\Models\Encuestum;
use App\Models\User;
use App\Models\Role;
use Gate;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Arr;
use App\Models\Ticket;


class HomeController
{
    public function index()
    {
        $id_cliente = Auth::user()->id;
        $id_rol_usuario = DB::table('users')
                    ->join('role_user', 'users.id', '=', 'role_user.user_id')
                    ->where('users.id', $id_cliente) 
                    ->select('role_user.role_id')
                    ->get();       
        $id_rol_usuario = $id_rol_usuario->first()->role_id;

        $rol_usuario = DB::table('roles')
                    ->where('id', $id_rol_usuario)
                    ->value('title');

        if($rol_usuario == "Admin"){
            $proyectos = Proyecto::paginate(5);
            $p_activos = Proyecto::where('estado', '=', 'Activo')->count();
            $p_finalizados = Proyecto::where('estado', '=', 'Despachado')->count();
        }else{
            $proyectos = Proyecto::join('proyecto_user', 'proyectos.id', '=', 'proyecto_user.proyecto_id')
                    ->where('proyecto_user.user_id', $id_cliente)
                    ->select('proyectos.*', 'proyecto_user.user_id')
                    ->paginate(5);          
            $p_activos = Proyecto::join('proyecto_user', 'proyectos.id', '=', 'proyecto_user.proyecto_id')
                    ->where('proyecto_user.user_id', $id_cliente)
                    ->where('proyectos.estado', '=', 'Activo')
                    ->select('proyectos.*', 'proyecto_user.user_id')
                    ->count();

            $p_finalizados = Proyecto::join('proyecto_user', 'proyectos.id', '=', 'proyecto_user.proyecto_id')
                    ->where('proyecto_user.user_id', $id_cliente)
                    ->where('proyectos.estado', '=', 'Despachado')
                    ->select('proyectos.*', 'proyecto_user.user_id')
                    ->count();
        }

        $empresas  = Empresa::all();
        $users     = User::all();
        $sucursals = Sucursal::all();
        $tickets = Ticket::all()->count();
        $t_activos = Ticket::where('estado', '=', 'Activo')->count();
        $t_finalizados = Ticket::where('estado', '=', 'Finalizado')->count();
        $encuesta = Encuestum::paginate(5);
        
        if($tickets){
            $percent_activos = round(((100*$t_activos)/$tickets),0);
            $percent_finalizados = round(((100*$t_finalizados)/$tickets),0);
        }else{            
            $percent_activos = 0;
            $percent_finalizados = 0;
        }
        
        return view('home', compact('empresas', 'users', 'sucursals', 'proyectos', 'p_activos', 'p_finalizados', 'tickets', 't_finalizados', 't_activos', 'percent_activos', 'percent_finalizados', 'encuesta'));
    }

    public function kpis(){

        return view('kpis');

    }
}
