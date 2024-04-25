@extends('layouts.admin')
@section('content')
@can('carpetacliente_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.carpetaclientes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carpetacliente.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carpetacliente.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Carpetacliente">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
                    <th>
                        {{ trans('cruds.carpetacliente.fields.nb') }}
                    </th>
                    <th>
                        {{ trans('cruds.carpetacliente.fields.course') }}
                    </th>
                    <th>
                        {{ trans('cruds.carpetacliente.fields.id_fase_comercial') }}
                    </th>
                    <th>
                        &nbsp;
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
@can('carpetacliente_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.carpetaclientes.massDestroy') }}",
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.carpetaclientes.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'presupuesto', name: 'presupuesto', sortable: false, searchable: false },
{ data: 'plano', name: 'plano', sortable: false, searchable: false },
{ data: 'fftt', name: 'fftt', sortable: false, searchable: false },
{ data: 'presentacion', name: 'presentacion', sortable: false, searchable: false },
{ data: 'rectificacion', name: 'rectificacion', sortable: false, searchable: false },
{ data: 'nb', name: 'nb', sortable: false, searchable: false },
{ data: 'course', name: 'course', sortable: false, searchable: false },
{ data: 'id_fase_comercial_estado', name: 'id_fase_comercial.estado' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Carpetacliente').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection