<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Carbon\Carbon;
use App\Models\UserAlert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\NotificarTicket;


class TicketController extends Controller
{

    public function Alerta_modifica($id_proyecto, $texto){
        $proyecto_info = Proyecto::with('id_usuarios_clientes')->find($id_proyecto);
        $data_alerta = ["alert_text" => $texto, "aler_link" => "test test test"];
        $i=0;
        foreach ($proyecto_info->id_usuarios_clientes as $usuario_cliente){
            $data_alert_users = ["i" => $usuario_cliente->id];
            $i=$i+1;
        }
        $userAlert = UserAlert::create($data_alerta);
        $userAlert->users()->sync($data_alert_users);

    }
    public function getVendedor(Request $request){
        $id_proyecto = $request->id_proyecto;
        $response = DB::select("SELECT id_vendedor FROM proyectos WHERE id =".$id_proyecto);
        $id_vendedor = $response[0]->id_vendedor;
        
         return response()->json($id_vendedor);
    }
    public function storeMensaje(Request $request){
         $sender_id = Auth::user()->id;
         $current_timestamp = Carbon::now()->toDateTimeString();
        DB::table('mensajes_ticket')->insert(
            array('sender_id' => $sender_id,
                  'ticket_id' => $request->ticket_id,
                  'mensaje' => $request->mensaje,
                  'created_at' => $current_timestamp,
        )
        );
        $solicitud = Ticket::find($request->ticket_id);
        //dd($solicitud );
        $proyecto = Proyecto::find($solicitud->proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
        $vendedorID = $solicitud->vendedor_id;
        $clienteID = $solicitud->user_id;
        $tipo_usuario = "Vendedor";
        if ($proyecto) {
            $id_proyecto = $proyecto->id;
            $nombre_proyecto = $proyecto->nombre_proyecto;
            if ($vendedorID) {
                $user_vendedor = User::find($vendedorID);
                $email_vendedor = $user_vendedor->email;
                $name_vendedor = $user_vendedor->name;

                $user_cliente = User::find($clienteID);
                $email_cliente = $user_cliente->email;
                $name_cliente = $user_cliente->name;
                if ($email_vendedor) {
                    Mail::to($email_vendedor)->send(new NotificarTicket($nombre_proyecto, $name_vendedor, $name_cliente, $tipo_usuario, $id_proyecto));
                } else {
                }
            }
        }

        return back();
    }

    public function index()
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        // Obtén el ID del usuario actualmente autenticado
        $userId = auth()->user()->id;
    
        // Filtra los tickets por el user_id actual
        $tickets = Ticket::with(['proyecto', 'users'])
            ->where('user_id', $userId)
            ->get();
    
        return view('frontend.tickets.index', compact('tickets'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user_id = Auth::user()->id;
        $empresa_user = Auth::user()->empresa_id;
        //$proyectos = Proyecto::where('id_cliente_id', $empresa_user)->with(['id_cliente', 'id_usuarios_clientes', 'sucursal','vendedor'])->get();
        $proyectos = Proyecto::where('id_cliente_id', $empresa_user)->pluck('nombre_proyecto', 'id');
       // $proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id');
        //dd($proyectos);
        $proyecto_id = $request->input('proyecto_id');
        
        $proyec = Proyecto::find($proyecto_id);
        $nombre_proyecto = $proyec->nombre_proyecto;
        return view('frontend.tickets.create', compact('proyectos', 'users', 'user_id','proyecto_id','nombre_proyecto'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());

     
        $current_timestamp = Carbon::now()->toDateTimeString();

        DB::table('mensajes_ticket')->insert(
            array('sender_id' => $ticket->user_id,
                  'ticket_id' => $ticket->id,
                  'mensaje' => $request->mensaje,
                  'created_at' => $current_timestamp,
        )
        );
        $txt = "Se ha creado un Ticket.";
        $this->Alerta_modifica($request->proyecto_id, $txt);

        $proyecto = Proyecto::find($request->proyecto_id); // Suponiendo que el modelo de Proyecto se llama Proyecto
        $vendedorID = $request->vendedor_id;
        $clienteID = $request->user_id;
        $tipo_usuario = "Vendedor";
        if ($proyecto) {
            $id_proyecto = $proyecto->id;
            $nombre_proyecto = $proyecto->nombre_proyecto;
            if ($vendedorID) {
                $user_vendedor = User::find($vendedorID);
                $email_vendedor = $user_vendedor->email;
                //dd($tipo_usuario);
                $name_vendedor = $user_vendedor->name;

                $user_cliente = User::find($clienteID);
                $email_cliente = $user_cliente->email;
                $name_cliente = $user_cliente->name;
                if ($email_vendedor) {
                    Mail::to($email_vendedor)->send(new NotificarTicket($nombre_proyecto, $name_vendedor, $name_cliente, $tipo_usuario, $id_proyecto));
                } else {
                }
            }
        }

        return redirect()->route('frontend.tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id');

        $ticket->load('proyecto', 'users');

        return view('frontend.tickets.edit', compact('proyectos', 'ticket', 'users'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        $ticket->users()->sync($request->input('users', []));

        return redirect()->route('frontend.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('proyecto', 'users');

        return view('frontend.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        $tickets = Ticket::find(request('ids'));

        foreach ($tickets as $ticket) {
            $ticket->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}