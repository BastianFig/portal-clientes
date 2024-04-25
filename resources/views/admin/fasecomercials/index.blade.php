@extends('layouts.admin')
@section('content')
@can('fasecomercial_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fasecomercials.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fasecomercial.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fasecomercial.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Fasecomercial">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.comentarios') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.cotizacion') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.oc') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.estado') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecomercial.fields.id_proyecto') }}
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
@can('fasecomercial_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fasecomercials.massDestroy') }}",
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
    ajax: "{{ route('admin.fasecomercials.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'comentarios', name: 'comentarios' },
{ data: 'cotizacion', name: 'cotizacion', sortable: false, searchable: false },
{ data: 'oc', name: 'oc', sortable: false, searchable: false },
{ data: 'estado', name: 'estado' },
{ data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Fasecomercial').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection