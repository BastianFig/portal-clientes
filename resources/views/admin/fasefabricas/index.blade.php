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
                    <th>
                        Acciones
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
<script>
    $(function () {
   let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
/* @can('fasefabrica_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
   let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fasefabricas.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  } 
  dtButtons.push(deleteButton)
@endcan */
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.fasefabricas.index') }}",
    columns: [
{ data: 'id', name: 'id' },
{ 
        data: 'actions',
        name: '{{ trans('global.actions') }}',
        render: function (data, type, full, meta) {
            // Verificamos si la acción es de tipo editar
            if (type === 'display' && meta.col === 1) {
                // Obtenemos el ID del elemento actual
                var id = full['id'];
                
                // Creamos el enlace con la URL de edición
                data = '<a href="/admin/fasefabricas/' + id + '/edit" class="btn btn-primary">Ver</a>';
            }
            return data;
        }
    },
{ data: 'aprobacion_course', name: 'aprobacion_course' },
{ data: 'oc_proveedores', name: 'oc_proveedores', sortable: false, searchable: false },
{ data: 'estado_produccion', name: 'estado_produccion' },
{ data: 'fecha_entrega', name: 'fecha_entrega' },
{ data: 'galeria_estado_entrega', name: 'galeria_estado_entrega', sortable: false, searchable: false },
{ data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
{ data: 'estado', name: 'estado' },
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 10,
  };
  console.log(dtOverrideGlobals)
  let table = $('.datatable-Fasefabrica').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

   

</script>
@endsection