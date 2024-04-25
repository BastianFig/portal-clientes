<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\Proyecto;
use App\Models\Sucursal;
use App\Models\Ticket;
use App\Models\Encuesta;
use App\Models\User;
use Auth;
use Arr;

class HomeController
{
    public function index()
    {
        $id_vendedor = Auth::user()->id;
        $sucursal_user = User::where('id', '=', $id_vendedor)->with(['sucursals'])->get()->toArray();
        //$sucursal = $sucursal_user->pivot->id;
        $empresa_user = Auth::user()->empresa_id;
        $sucursales_empresa = Sucursal::where('empresa_id','=', $empresa_user)->get()->toArray();

        $sort = Arr::prepend($sucursales_empresa, $sucursal_user);
        //$empresa_user = Auth::user()->empresa_id;
        $sucursales = Sucursal::where('empresa_id', '=', $empresa_user)->get();
        //$sortOrder = array_flip([$sucursal_user->sucursals->id]) ;
        $result = Proyecto::where('id_cliente_id', $empresa_user)->with(['id_cliente', 'id_usuarios_clientes', 'sucursal','vendedor', 'encuesta'])->get();
        
        $solicitudes = Ticket::where('user_id', $id_vendedor)->where('estado', '=', 'Activo')->count();
       /* $activos = Proyecto::where('id_vendedor', $id_vendedor)->where(function($query) {
                       $query->where('estado', '=', 'Proyecto Caliente')
                             ->orWhere('estado', '=', 'Proyecto Interesante')
                             ->orWhere('estado', '=', 'Proyecto Potencial');
                   })
                  ->count();*/
                  
       $activos = Proyecto::join('proyecto_user', 'proyecto_user.proyecto_id', '=', 'proyectos.id')
        ->where('proyecto_user.user_id', $id_vendedor)
        ->where(function($query) {
            $query->where('proyectos.estado', '=', 'Proyecto Caliente')
                  ->orWhere('proyectos.estado', '=', 'Proyecto Interesante')
                  ->orWhere('proyectos.estado', '=', 'Proyecto Potencial');
        })->count();
        
        /*$finalizados = Proyecto::where('id_vendedor', $id_vendedor)->where(function($query) {
                       $query->where('estado', '=', 'Negocio Ganado')
                             ->orWhere('estado', '=', 'Negocio Perdido');
                   })->count();*/
                   
         $finalizados = Proyecto::join('proyecto_user', 'proyecto_user.proyecto_id', '=', 'proyectos.id')
        ->where('proyecto_user.user_id', $id_vendedor)->where(function($query) {
                       $query->where('estado', '=', 'Negocio Ganado')
                             ->orWhere('estado', '=', 'Negocio Perdido');
                   })->count();
      


        
        //$proyectos = Proyecto::where('id_vendedor', '=', $id_vendedor)->get();
        $proyectos = Proyecto::join('proyecto_user', 'proyecto_user.proyecto_id', '=', 'proyectos.id')
                     ->where('proyecto_user.user_id', $id_vendedor)
                     ->get();

        $resultados = $proyectos->count();
        
        return view('frontend.home', compact('proyectos', 'sucursal_user', 'sucursales_empresa','sort', 'activos', 'finalizados', 'solicitudes', 'resultados'));
    }
}
