@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('carpetacliente_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            {{-- <a class="btn btn-success" href="{{ route('frontend.carpetaclientes.create') }}"
                                style="border-radius: 10px;">
                                {{ trans('global.add') }} {{ trans('cruds.carpetacliente.title_singular') }}
                            </a> --}}
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('global.list') }} de {{ trans('cruds.carpetacliente.title_singular') }}</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="overflow: scroll !important">
                            <table class=" datatable datatable-Carpetacliente table table-striped">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.presupuesto') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.plano') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.fftt') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.presentacion') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.rectificacion') }}
                                        </th>
                                        {{-- <th>
                                            {{ trans('cruds.carpetacliente.fields.nb') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.course') }}
                                        </th>--}}
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carpetaclientes as $key => $carpetacliente)
                                        <tr data-entry-id="{{ $carpetacliente->id }}" class="tabla-personalizada">
                                            <td>
                                                {{ $carpetacliente->id ?? '' }}
                                            </td>
                                            <td>
                                                @if ($carpetacliente->presupuesto)
                                                    <a href="{{ $carpetacliente->presupuesto->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($carpetacliente->plano as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($carpetacliente->fftt as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($carpetacliente->presentacion as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($carpetacliente->rectificacion)
                                                    <a href="{{ $carpetacliente->rectificacion->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                           {{-- <td>
                                                @if ($carpetacliente->nb)
                                                    <a href="{{ $carpetacliente->nb->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($carpetacliente->course)
                                                    <a href="{{ $carpetacliente->course->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>--}}
                                            <td>
                                                @can('carpetacliente_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.carpetaclientes.show', $carpetacliente->id) }}"
                                                        style="border-radius: 10px">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('carpetacliente_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.carpetaclientes.edit', $carpetacliente->id) }}"
                                                        style="border-radius: 10px">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('carpetacliente_delete')
                                                    <form
                                                        action="{{ route('frontend.carpetaclientes.destroy', $carpetacliente->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger"
                                                            value="{{ trans('global.delete') }}" style="border-radius: 10px;">
                                                    </form>
                                                @endcan

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
            @can('carpetacliente_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.carpetaclientes.massDestroy') }}",
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
            let table = $('.datatable-Carpetacliente:not(.ajaxTable)').DataTable({
                buttons: dtButtons,
                scrollX: 400,
                language: {
                    'to': 'a',
                    'of': 'de',
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
                        "next": "  Siguiente >>",
                        "previous": "<< Anterior ",
                        'to': 'a',
                        'of': 'de',
                    }
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
