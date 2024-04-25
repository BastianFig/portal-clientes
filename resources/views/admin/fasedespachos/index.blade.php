@extends('layouts.admin')
@section('content')
@can('fasedespacho_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <!--<a class="btn btn-success" href="{{ route('admin.fasedespachos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fasedespacho.title_singular') }}
            </a>-->
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fasedespacho.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Fasedespacho">
            <thead>
                <tr>
                    <th width="10">
                        {{ trans('cruds.fasedespacho.fields.id') }}
                    </th>
                    <th>
                        Acciones
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.guia_despacho') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.fecha_despacho') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.estado_instalacion') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.recibe_conforme') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.galeria_estado_muebles') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.id_proyecto') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasedespacho.fields.estado') }}
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
/*@can('fasedespacho_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fasedespachos.massDestroy') }}",
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
@endcan
*/
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.fasedespachos.index') }}",
    columns: [
    { data: 'id', name: 'id' },
    { 
        data: 'actions',
        name: '{{ trans('global.actions') }}',
        render: function (data, type, full, meta) {
            // Verificamos si la acci贸n es de tipo editar
            if (type === 'display' && meta.col === 1) {
                // Obtenemos el ID del elemento actual
                var id = full['id'];
                
                // Creamos el enlace con la URL de edici贸n
                data = '<a href="/admin/fasedespachos/' + id + '/edit" class="btn btn-primary">Ver</a>';
            }
            return data;
        }
    },
    { data: 'guia_despacho', name: 'guia_despacho', sortable: false, searchable: false },
    { data: 'fecha_despacho', name: 'fecha_despacho' },
    { data: 'estado_instalacion', name: 'estado_instalacion' },
    { data: 'recibe_conforme', name: 'recibe_conforme' },
    { data: 'galeria_estado_muebles', name: 'galeria_estado_muebles', sortable: false, searchable: false },
    { data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
    { data: 'estado', name: 'estado' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Fasedespacho').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection