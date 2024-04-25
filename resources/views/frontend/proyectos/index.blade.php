@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('proyecto_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            {{-- <a class="btn btn-success" href="{{ route('frontend.proyectos.create') }}" style="border-radius: 10px">
                                {{ trans('global.add') }} {{ trans('cruds.proyecto.title_singular') }}
                            </a> --}}
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        <h3>{{ trans('global.list') }} de {{ trans('cruds.proyecto.title_singular') }}s</h3>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive"style="overflow: scroll;">

                            <table class="datatable datatable-Proyecto table-striped" style="overflow: scroll;">

                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.proyecto.fields.nombre_proyecto') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.proyecto.fields.sucursal') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.direccion_sucursal') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.proyecto.fields.estado') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.proyecto.fields.fase') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($proyectos as $key => $proyecto)
                                        <tr data-entry-id="{{ $proyecto->id }}" class="tabla-personalizada">

                                            <td>
                                                {{ $proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $proyecto->sucursal->nombre ?? '' }}
                                            </td>
                                            <td>
                                                {{ $proyecto->sucursal->direccion_sucursal ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Proyecto::ESTADO_SELECT[$proyecto->estado] ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Proyecto::FASE_SELECT[$proyecto->fase] ?? '' }}
                                            </td>

                                            <td>
                                                @can('proyecto_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.proyectos.show', $proyecto->id) }}"
                                                        style="border-radius: 10px">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('proyecto_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.proyectos.edit', $proyecto->id) }}"
                                                        style="border-radius: 10px">
                                                        {{ trans('global.edit') }}
                                                    </a>
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
            @can('proyecto_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.proyectos.massDestroy') }}",
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
            let table = $('.datatable-Proyecto:not(.ajaxTable)').DataTable({
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
                    }
                }
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value

                let index = $(this).parent().index()
                if (visibleColumnsIndexes !== null) {
                    index = visibleColumnsIndexes[index]
                }

                table
                    .column(index)
                    .search(value, strict)
                    .draw()
            });
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        })
    </script>
@endsection
