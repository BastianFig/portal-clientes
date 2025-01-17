@extends('layouts.admin')
@section('content')
@can('proyecto_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.proyectos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.proyecto.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.proyecto.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Proyecto">
            <thead>
                <tr>
                    <th width="10">
                        {{ trans('cruds.proyecto.fields.id') }}
                    </th>
                    <th width="10">

                    </th>

                    <th>
                        {{ trans('cruds.proyecto.fields.nombre_proyecto') }}
                    </th>
                    <th>
                        Nota de Venta
                    </th>
                    <th>
                        Fecha
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.id_cliente') }}
                    </th>
                    <th>
                        {{ trans('cruds.empresa.fields.rut') }}
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.id_usuarios_cliente') }}
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.sucursal') }}
                    </th>
                    <th>
                        {{ trans('cruds.sucursal.fields.direccion_sucursal') }}
                    </th>
                    <th>
                        Categoría Proyecto
                    </th>
                    <th>
                        Tipo Proyecto
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.estado') }}
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.fase') }}
                    </th>
                </tr>
                <tr>
                    <td>

                    </td>
                    <td>

                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>

                    </td>
                    <td class="td_search">
                        <select class="search" id="search_empresa">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($empresas as $key => $item)
                                <option value="{{ $item->nombe_de_fantasia }}">{{ $item->nombe_de_fantasia }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" id="search_rut">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($empresas2 as $key => $item)
                                <option value="{{ $item->rut }}">{{ $item->rut }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" id="search_cliente">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <select class="search" name="sucursal" id="search_sucursal">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach ($sucursals as $key => $item)
                                <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <!-- <input class="search" type="text" placeholder="{{ trans('global.search') }}">-->

                    </td>
                    <td>
                        <select class="search" strict="true" id="search_categoria_proyecto">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach (App\Models\Proyecto::CATEGORIA_PROYECTO_SELECT as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true" id="search_tipo_proyecto">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach (App\Models\Proyecto::TIPO_PROYECTO_SELECT as $key => $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach (App\Models\Proyecto::ESTADO_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <!--<select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach (App\Models\Proyecto::FASE_SELECT as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>-->
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
        // $('#search_empresa').select2();
        // $('#search_rut').select2();
        // $('#search_cliente').select2();
        // $('#search_sucursal').select2();
        // $('#search_tipo_proyecto').select2();
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('proyecto_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.proyectos.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).data(), function (entry) {
                        return entry.id
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
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
        @endcan

        let dtOverrideGlobals = {
            buttons: dtButtons,
            processing: true,
            serverSide: true,
            retrieve: true,
            aaSorting: [],
            searching: true,
            ajax: "{{ route('admin.proyectos.index') }}",
            columns: [{
                data: 'placeholder',
                name: 'id'
            },
            {
                data: 'actions',
                name: 'id'
            },
            {
                data: 'nombre_proyecto',
                name: 'nombre_proyecto'
            },
            {
                data: 'orden',
                name: 'orden'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'id_cliente_nombe_de_fantasia',
                name: 'id_cliente.nombe_de_fantasia'
            },
            {
                data: 'id_cliente.rut',
                name: 'id_cliente.rut'
            },
            {
                data: 'id_usuarios_cliente',
                name: 'id_usuarios_clientes.name'
            },
            {
                data: 'sucursal_nombre',
                name: 'sucursal.nombre'
            },
            {
                data: 'sucursal.direccion_sucursal',
                name: 'sucursal.direccion_sucursal'
            },
            {
                data: 'categoria_proyecto',
                name: 'categoria_proyecto'
            },
            {
                data: 'tipo_proyecto',
                name: 'tipo_proyecto'
            },
            {
                data: 'estado',
                name: 'estado'
            },
            {
                data: 'fase',
                name: 'fase'
            }
            ],
            orderCellsTop: true,
            order: [
                [3, 'desc']
            ],
            pageLength: 10,
        };
        let table = $('.datatable-Proyecto').DataTable(dtOverrideGlobals);
        $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        let visibleColumnsIndexes = null;
        $('.datatable thead').on('input', '.search', function () {
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
        table.on('column-visibility.dt', function (e, settings, column, state) {
            visibleColumnsIndexes = []
            table.columns(":visible").every(function (colIdx) {
                visibleColumnsIndexes.push(colIdx);
            });
        })
    });
</script>
@endsection