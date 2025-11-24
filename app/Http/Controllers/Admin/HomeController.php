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

        if ($rol_usuario == "Admin" || $rol_usuario == 'Fabrica') {
            $proyectos = Proyecto::paginate(5);
            //$p_activos = Proyecto::where('estado', '=', 'Activo')->count();
            $p_activos = Proyecto::whereIn('estado', ['Proyecto Caliente', 'Proyecto Interesante', 'Proyecto Potencial'])->count();
            //$p_finalizados = Proyecto::where('estado', '=', 'Despachado')->count();
            $p_finalizados = Proyecto::whereIn('estado', ['Negocio Ganado', 'Negocio Perdido'])->count();
        } else {
            /*$proyectos = Proyecto::join('proyecto_user', 'proyectos.id', '=', 'proyecto_user.proyecto_id')
                    ->where('proyecto_user.user_id', $id_cliente)
                    ->select('proyectos.*', 'proyecto_user.user_id')
                    ->paginate(5);    */

            //ULTIMO UTILIZADO //$proyectos = Proyecto::where('id_vendedor', $id_cliente)->orderBy('created_at', 'desc')->paginate(5);
            $proyectos = Proyecto::where(function ($query) use ($id_cliente) {
                $query->where('id_vendedor', $id_cliente)
                    ->orWhere('disenador', $id_cliente);
            })->orderBy('created_at', 'desc')->paginate(5);


            $p_activos = Proyecto::where(function ($query) use ($id_cliente) {
                $query->where('id_vendedor', $id_cliente)
                    ->orWhere('disenador', $id_cliente);
            })
                ->where(function ($query) {
                    $query->where('estado', 'Proyecto Caliente')
                        ->orWhere('estado', 'Proyecto Interesante')
                        ->orWhere('estado', 'Proyecto Potencial');
                })
                ->count();


            $p_finalizados = Proyecto::where(function ($query) use ($id_cliente) {
                $query->where('id_vendedor', $id_cliente)
                    ->orWhere('disenador', $id_cliente);
            })
                ->where(function ($query) {
                    $query->where('estado', 'Negocio Ganado')
                        ->orWhere('estado', 'Negocio Perdido');
                })
                ->count();

        }

        $empresas = Empresa::all();
        $users = User::all();
        $sucursals = Sucursal::all();
        $tickets = Ticket::all()->count();
        $t_activos = Ticket::where('estado', '=', 'Activo')->count();
        $t_finalizados = Ticket::where('estado', '=', 'Finalizado')->count();
        $encuesta = Encuestum::paginate(5);

        if ($tickets) {
            $percent_activos = round(((100 * $t_activos) / $tickets), 0);
            $percent_finalizados = round(((100 * $t_finalizados) / $tickets), 0);
        } else {
            $percent_activos = 0;
            $percent_finalizados = 0;
        }

        return view('home', compact('empresas', 'users', 'sucursals', 'proyectos', 'p_activos', 'p_finalizados', 'tickets', 't_finalizados', 't_activos', 'percent_activos', 'percent_finalizados', 'encuesta'));
    }

    public function kpis()
    {

        return view('kpis');

    }

    public function metricas()
    {
        $id_vendedor = Auth::user()->id;
        $id_rol_usuario = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('users.id', $id_vendedor)
            ->select('role_user.role_id')
            ->get();
        $id_rol_usuario = $id_rol_usuario->first()->role_id;

        $rol_usuario = DB::table('roles')
            ->where('id', $id_rol_usuario)
            ->value('title');

        if ($rol_usuario == "Admin") {
            $fases = [
                'Fase Diseño',
                'Fase Propuesta Comercial',
                'Fase Contable',
                'Fase Comercial',
                'Fase Fabricación',
                'Fase Despachos',
                'Fase Postventa'
            ];

            $proyectosAgrupados = DB::table('proyectos')
                ->join('users', 'proyectos.id_vendedor', '=', 'users.id') // Join con la tabla de usuarios
                ->rightJoin(DB::raw('(SELECT "' . implode('" as fase UNION SELECT "', $fases) . '" as fase) as todas_fases'), 'todas_fases.fase', '=', 'proyectos.fase')
                ->select(
                    'proyectos.id_vendedor',
                    'users.name as vendedor_nombre',
                    'todas_fases.fase',
                    DB::raw('IFNULL(count(proyectos.id), 0) as total_fase')
                )
                ->whereNull('proyectos.deleted_at') // Excluir proyectos eliminados
                ->whereNotIn('proyectos.id_vendedor', [1, 26]) // Excluir vendedores específicos
                ->groupBy('proyectos.id_vendedor', 'todas_fases.fase', 'users.name') // Agrupar por vendedor y fase
                ->orderByRaw("FIELD(todas_fases.fase, 
                        'Fase Diseño', 
                        'Fase Propuesta Comercial', 
                        'Fase Contable', 
                        'Fase Comercial', 
                        'Fase Fabricación', 
                        'Fase Despachos', 
                        'Fase Postventa')") // Orden específico de fases
                ->get();

            // Obtener el total de proyectos por vendedor
            $totalProyectosPorVendedor = DB::table('proyectos')
                ->select('id_vendedor', DB::raw('count(id) as total_proyectos'))
                ->whereNull('proyectos.deleted_at') // Excluir proyectos eliminados suavemente
                ->whereNotIn('proyectos.id_vendedor', [1, 26])
                ->groupBy('id_vendedor')
                ->pluck('total_proyectos', 'id_vendedor');
        }



        //fxdd($proyectosAgrupados);
        return view('admin.metricas', compact('proyectosAgrupados', 'totalProyectosPorVendedor'));
    }

    public function metricaspie()
    {
        $id_vendedor = Auth::user()->id;
        $id_rol_usuario = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->where('users.id', $id_vendedor)
            ->select('role_user.role_id')
            ->get();
        $id_rol_usuario = $id_rol_usuario->first()->role_id;

        $rol_usuario = DB::table('roles')
            ->where('id', $id_rol_usuario)
            ->value('title');

        if ($rol_usuario == "Admin") {
            $fases = [
                'Fase Diseño',
                'Fase Propuesta Comercial',
                'Fase Contable',
                'Fase Comercial',
                'Fase Fabricación',
                'Fase Despachos',
                'Fase Postventa'
            ];

            $proyectosAgrupados = DB::table('proyectos')
                ->join('users', 'proyectos.id_vendedor', '=', 'users.id')
                ->rightJoin(DB::raw('(SELECT "' . implode('" as fase UNION SELECT "', $fases) . '" as fase) as todas_fases'), 'todas_fases.fase', '=', 'proyectos.fase')
                ->select(
                    'proyectos.id_vendedor',
                    'users.name as vendedor_nombre',
                    'todas_fases.fase',
                    DB::raw('IFNULL(count(proyectos.id), 0) as total_fase')
                )
                ->whereNull('proyectos.deleted_at')
                ->whereNotIn('proyectos.id_vendedor', [1, 26])
                ->groupBy('proyectos.id_vendedor', 'todas_fases.fase', 'users.name')
                ->orderByRaw("FIELD(todas_fases.fase, 
                    'Fase Diseño', 
                    'Fase Propuesta Comercial', 
                    'Fase Contable', 
                    'Fase Comercial', 
                    'Fase Fabricación', 
                    'Fase Despachos', 
                    'Fase Postventa')")
                ->get();

            $totalProyectosPorVendedor = DB::table('proyectos')
                ->select('id_vendedor', DB::raw('count(id) as total_proyectos'))
                ->whereNull('proyectos.deleted_at')
                ->whereNotIn('proyectos.id_vendedor', [1, 26])
                ->groupBy('id_vendedor')
                ->pluck('total_proyectos', 'id_vendedor');

            // Calcular porcentajes para cada fase y vendedor
            $proyectosConPorcentaje = $proyectosAgrupados->map(function ($proyecto) use ($totalProyectosPorVendedor) {
                $totalProyectos = $totalProyectosPorVendedor[$proyecto->id_vendedor] ?? 1; // Evitar división por cero
                $proyecto->porcentaje_fase = ($proyecto->total_fase / $totalProyectos) * 100;
                return $proyecto;
            });
        }

        return view('admin.metricaspie', compact('proyectosConPorcentaje', 'totalProyectosPorVendedor'));
    }



}
