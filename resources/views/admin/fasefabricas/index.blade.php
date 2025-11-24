@extends('layouts.admin')
@section('content')
@can('fasefabrica_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <!--<a class="btn btn-success" href="{{ route('admin.fasefabricas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fasefabrica.title_singular') }}
            </a>-->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fasefabrica.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Fasefabrica">
            <thead>
                <tr>
                    <th width="10">
                        {{ trans('cruds.fasefabrica.fields.id') }}
                    </th>
                    <th width="10">

                    </th>
                    <th>
                        Curse
                    </th>
                    <th>
                        {{ trans('cruds.fasefabrica.fields.oc_proveedores') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasefabrica.fields.estado_produccion') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasefabrica.fields.fecha_entrega') }}
                    </th>
                    <th>
                        Packing List 
                    </th>
                    <th>
                        Proyecto
                    </th>
                    <th>
                        {{ trans('cruds.fasefabrica.fields.estado') }}
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<!-- En tu layout, probablemente en layouts/admin.blade.php -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [], // orden por ID descendente
        ajax: "{{ route('admin.fasefabricas.index') }}",
        columns: [
            { data: 'placeholder', name: 'ID' }, // columna 0
            { 
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    if (type === 'display') {
                        var id = full['id'];
                        return '<a href="/admin/fasefabricas/' + id + '/edit" class="btn btn-primary btn-sm">Ver</a>';
                    }
                    return data;
                }
            },
            { data: 'aprobacion_course', name: 'aprobacion_course' },
            { data: 'oc_proveedores', name: 'oc_proveedores', orderable: false, searchable: false },
            {
                data: 'estado_produccion',
                name: 'estado_produccion',
                render: function (data, type, full, meta) {
                    if (type === 'display') {
                        const options = ['Ingenieria','Produccion', 'Embalaje', 'Listo para despacho'];
                        let select = `<select class="form-control form-control-sm estado-produccion" data-id="${full.id}">`;
                        options.forEach(function (opt) {
                            const selected = data === opt ? 'selected' : '';
                            select += `<option value="${opt}" ${selected}>${opt}</option>`;
                        });
                        select += `</select>`;
                        return select;
                    }
                    return data;
                }
            },
            { data: 'fecha_entrega', name: 'fecha_entrega' },
            { data: 'galeria_estado_entrega', name: 'galeria_estado_entrega', orderable: false, searchable: false },
            { data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
            { data: 'estado', name: 'estado' },
        ],
        orderCellsTop: true,
        pageLength: 10,
    };

    let table = $('.datatable-Fasefabrica').DataTable(dtOverrideGlobals);

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    $(document).on('change', '.estado-produccion', function () {
        const id = $(this).data('id');
        const estado = $(this).val();

        $.ajax({
            url: "{{ route('admin.fasefabricas.updateEstadoProduccion') }}",
            method: 'POST',
            headers: {
                'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                estado_produccion: estado
            },
            success: function (response) {
                if (response.success) {
                    toastr.success('Estado actualizado correctamente');
                } else {
                    toastr.error('Error al actualizar estado');
                }
            },
            error: function () {
                toastr.error('Error al actualizar estado');
            }
        });
    });

});
</script>

@endsection