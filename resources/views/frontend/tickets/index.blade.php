@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('ticket_create')
                    <div style="margin-bottom: 10px;" class="row">
                       <!-- <div class="col-lg-12">
                            <a class="btn btn-success"style="border-radius:10px" href="{{ route('frontend.tickets.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.ticket.title_singular') }}
                            </a>
                        </div>-->
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('global.list') }} {{ trans('cruds.ticket.title_singular') }}</h3>
                    </div>

                    <div class="card-body"style="overflow: scroll !important">
                        <div class="table-responsive" style="overflow: scroll !important">
                            <table class=" datatable datatable-Ticket table-striped" style="overflow: scroll !important">
                                <thead class="h-100 sh-md-4 border-bottom border-separator-light pb-3 mb-3">
                                    <tr
                                        class="h-100 sh-md-4 border-bottom border-separator-light pb-3 mb-3 border-separator-light">
                                        <div class="row g-0 h-100 align-content-center">

                                            <th>
                                                {{ trans('cruds.ticket.fields.proyecto') }}
                                            </th>
                                            <th>
                                                {{ trans('cruds.proyecto.fields.estado') }}
                                            </th>
                                            <th>
                                                {{ trans('cruds.ticket.fields.user') }}
                                            </th>
                                            <th>
                                                {{ trans('cruds.ticket.fields.asunto') }}
                                            </th>
                                            <th>
                                                &nbsp;
                                            </th>
                                        </div>
                                    </tr>
                                </thead>
                                <tbody class="card-body mb-5" style="overflow: scroll !important">
                                    @foreach ($tickets as $key => $ticket)
                                        <tr data-entry-id="{{ $ticket->id }}" id=""
                                            class="border-separator-light tabla-personalizada"
                                            style="overflow: scroll !important"
                                            >

                                            <td class="text-alternate">
                                                {{ $ticket->proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td class="text-alternate">
                                                @if ($ticket->proyecto)
                                                    {{ $ticket->proyecto::ESTADO_SELECT[$ticket->proyecto->estado] ?? '' }}
                                                @endif
                                            </td>
                                            <td class="text-alternate">

                                                @if ($ticket->users != NULL)
                                                    <span>{{ $ticket->users->name }}</span>
                                                @endif
                                            </td>
                                            <td class="text-alternate">
                                                {{ $ticket->asunto ?? '' }}
                                            </td>
                                            <td class="text-alternate">
                                                @can('ticket_show')
                                                    <a class="btn btn-xs btn-primary" style="border-radius:10px"
                                                        href="{{ route('frontend.tickets.show', $ticket->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('ticket_delete')
                                                    <form action="{{ route('frontend.tickets.destroy', $ticket->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" style="border-radius:10px"
                                                            class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan

                                            </td>
                                        </tr>
                                        <span id="tabla-personalizada"></span>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- test -->

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('ticket_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.tickets.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Ticket:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente >>",
                        "previous": "<< Anterior"
                    },
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust()
            });

        })
    </script>
@endsection
