@extends('layouts.admin')
@section('content')
@can('fase_postventum_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fase-postventa.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fasePostventum.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fasePostventum.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FasePostventum">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.encuesta') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.ticket') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.id_proyecto') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.id_usuario') }}
                    </th>
                    <th>
                        {{ trans('cruds.fasePostventum.fields.estado') }}
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
@can('fase_postventum_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fase-postventa.massDestroy') }}",
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
    ajax: "{{ route('admin.fase-postventa.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'encuesta_observacion', name: 'encuesta.observacion' },
{ data: 'ticket_asunto', name: 'ticket.asunto' },
{ data: 'id_proyecto_nombre_proyecto', name: 'id_proyecto.nombre_proyecto' },
{ data: 'id_usuario', name: 'id_usuarios.name' },
{ data: 'estado', name: 'estado' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-FasePostventum').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection