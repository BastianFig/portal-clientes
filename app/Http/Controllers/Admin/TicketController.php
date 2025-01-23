<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Proyecto;
use App\Models\Ticket;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\UserAlert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\NotificarTicket;
use App\Mail\AsignarTicket;

class TicketController extends Controller
{
    public function cerrarTicket(Request $request)
    {
        $id_ticket = $request->ticket_id;
        $ticket = Ticket::find($id_ticket);
        if ($ticket) {
            $ticket->estado = 'Finalizado';
            $ticket->update();
        }

        return back();
    }


    public function asignarVendedor(Request $request)
    {
        $id_ticket = $request->ticket_id;
        $ticket = Ticket::find($id_ticket);
        if ($ticket) {
            $ticket->vendedor_id = $request->id_vendedor;
            $ticket->update();
        }

        $evelyn = User::find($request->id_vendedor)->first();
        $email = $evelyn->email;
        $nombre = $evelyn->name;
        dd($evelyn);
        if ($evelyn) {
            Mail::to('jvergara@probit.cl')->send(new AsignarTicket($nombre, $id_ticket));
        }

        return back();
    }

    public function getVendedor(Request $request)
    {
        $id_proyecto = $request->id_proyecto;
        $response = DB::select("SELECT id_vendedor FROM proyectos WHERE id =" . $id_proyecto);
        $id_vendedor = $response[0]->id_vendedor;

        return response()->json($id_vendedor);
    }
    public function storeMensaje(Request $request)
    {
        $sender_id = Auth::user()->id;
        $current_timestamp = Carbon::now()->toDateTimeString();
        DB::table('mensajes_ticket')->insert(
            array(
                'sender_id' => $sender_id,
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
        $tipo_usuario = "Cliente";
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
                    Mail::to($email_cliente)->send(new NotificarTicket($nombre_proyecto, $name_vendedor, $name_cliente, $tipo_usuario, $id_proyecto));
                } else {
                }
            }
        }

        DB::update('UPDATE tickets SET updated_at = "' . $current_timestamp . '" WHERE id = ' . $solicitud->id);

        return back();
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('ticket_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Ticket::with(['proyecto', 'users'])->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'ticket_show';
                $editGate = 'ticket_edit';
                $deleteGate = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view(
                    'partials.datatablesActions',
                    compact(
                        'viewGate',
                        'editGate',
                        'deleteGate',
                        'crudRoutePart',
                        'row'
                    )
                );
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('proyecto_nombre_proyecto', function ($row) {
                return $row->proyecto ? $row->proyecto->nombre_proyecto : '';
            });

            $table->editColumn('proyecto.estado', function ($row) {
                return $row->proyecto ? (is_string($row->proyecto) ? $row->proyecto : $row->proyecto->estado) : '';
            });
            $table->editColumn('asunto', function ($row) {
                return $row->asunto ? $row->asunto : '';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->users ? $row->users->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'proyecto', 'user']);

            return $table->make(true);
        }

        return view('admin.tickets.index');
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user_id = Auth::user()->id;

        $proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id');

        return view('admin.tickets.create', compact('proyectos', 'users', 'user_id'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());


        $current_timestamp = Carbon::now()->toDateTimeString();

        DB::table('mensajes_ticket')->insert(
            array(
                'sender_id' => $ticket->user_id,
                'ticket_id' => $ticket->id,
                'mensaje' => $request->mensaje,
                'created_at' => $current_timestamp,
            )
        );

        return redirect()->route('admin.tickets.index');
    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $proyectos = Proyecto::pluck('nombre_proyecto', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id');

        $ticket->load('proyecto', 'users');

        return view('admin.tickets.edit', compact('proyectos', 'ticket', 'users'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->update($request->all());
        $ticket->users()->sync($request->input('users', []));

        return redirect()->route('admin.tickets.index');
    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('proyecto', 'users');
        return view('admin.tickets.show', compact('ticket'));
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
