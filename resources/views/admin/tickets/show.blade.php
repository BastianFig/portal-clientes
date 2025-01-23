@extends('layouts.admin')
@section('content')

<div class="col">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.ticket.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="form-group d-flex">
                                <a class="btn btn-primary mr-5" href="{{ route('admin.tickets.index') }}"
                                    style="border-radius:10px">Volver</a>
                                <form method="POST" action="{{route('admin.tickets.asignarVendedor')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id_vendedor" class="id_vendedor" name="id_vendedor"
                                        value="42">
                                    @if($ticket->proyecto->id_vendedor == 42)
                                        <a class="btn btn-warning ml-5 mr-5" href="#"
                                            style="border-radius:10px; color:black;" disabled>Asignar a vendedor</a>
                                    @else
                                        <a class="btn btn-warning ml-5 mr-5" href="#"
                                            style="border-radius:10px; color:black;">Asignar a vendedor</a>
                                    @endif

                                </form>
                                <form method="POST" action="{{route('admin.tickets.cerrarTicket')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="ticket_id" class="ticket_id" name="ticket_id"
                                        value="{{$ticket->id}}">
                                    @if($ticket->estado == "Activo")
                                        <input class="btn btn-danger text-white  ml-5" id="btn_finalizar_ticket"
                                            type="submit" value="Finalizar Ticket">
                                    @endif
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody class="col-6">
                                <tr class="col-6">
                                    <th class="col-6">
                                        {{ trans('cruds.ticket.fields.proyecto') }}
                                    </th>
                                    <td class="col-6">
                                        {{ $ticket->proyecto->nombre_proyecto ?? '' }}
                                    </td>
                                </tr>
                                <tr class="col-6">
                                    <th class="col-6">
                                        Creador
                                    </th>
                                    <td class="col-6">
                                        <span class="label label-info">{{ $ticket->users->name }}</span>
                                    </td>
                                </tr>
                                <tr class="col-6">
                                    <th class="col-6">
                                        Asignado
                                    </th>
                                    <td class="col-6">
                                        <span class="label label-info">{{ $ticket->vendedor->name }}</span>
                                    </td>
                                </tr>
                                <tr class="col-6">
                                    <th class="col-6">
                                        {{ trans('cruds.ticket.fields.asunto') }}
                                    </th>
                                    <td class="col-6">
                                        {{ $ticket->asunto }}
                                    </td>
                                </tr>
                                <tr class="col-6">
                                    <th class="col-6">
                                        Estado
                                    </th>
                                    <td class="col-6">
                                        {{ $ticket->estado }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card">
                        <p>
                        <h2>Historial de solicitud</h2>
                        </p>
                        @foreach ($ticket->mensaje as $mensaje)
                            <div class="card"
                                style="margin: 1rem 0; border:1px solid rgba(128, 128, 128, 0.3); border-radius: 5px">
                                <div class="card-body">
                                    <h5 class="card-title"><strong>Enviado por :</strong> {{ $mensaje->sender->name }}
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted"><strong>Fecha :</strong>
                                        {{ $mensaje->created_at }}</h6>

                                    <p class="card-header">{{ $mensaje->mensaje }}</p>

                                </div>
                            </div>
                            <span class="label label-info"></span>
                        @endforeach
                        @if($ticket->estado == "Activo")
                            <form action="{{ route('admin.tickets.storeMensaje') }}" method="post">
                                @csrf
                                <div class="input-group mb-3 col-12">


                                    <input type="hidden" name="proyecto_id" value="{{ $ticket->proyecto_id }}">
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                    <textarea style="border-radius:10px;" class="form-control" name="mensaje"
                                        placeholder="Envía un nuevo mensaje..." aria-label="Recipient's new message"
                                        aria-describedby="button-addon2"></textarea>
                                    <input class="btn btn-outline-success" style="border-radius:10px; margin:0 1rem"
                                        type="submit" id="btn-enviar-mensaje-ticket" value="Enviar" />
                                </div>
                            </form>
                        @endif
                    </div>

                </div>

            </div>

            <div class="form-group mb-3 col-12">
                <a class="btn btn-default" href="{{ route('admin.tickets.index') }}" style="border-radius:10px">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>


@endsection