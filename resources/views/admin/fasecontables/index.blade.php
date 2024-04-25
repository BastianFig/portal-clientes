@extends('layouts.admin')
@section('content')
@can('fasecontable_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fasecontables.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fasecontable.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fasecontable.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Fasecontable">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.anticipo_50') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.comentario') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.anticipo_40') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.anticipo_10') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.id_proyecto') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasecontable.fields.estado') }}
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
@can('fasecontable_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fasecontables.massDestroy') }}",
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
    ajax: "{{ route('admin.fasecontables.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'anticipo_50', name: 'anticipo_50', sortable: false, searchable: false },
{ data: 'comentario', name: 'comentario' },
{ data: 'anticipo_40', name: 'anticipo_40', sortable: false, searchable: false },
{ data: 'anticipo_10', name: 'anticipo_10', sortable: false, searchable: false },
{ data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
{ data: 'estado', name: 'estado' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Fasecontable').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection