@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        Lista de
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Ticket">
            <thead>
                <tr>
                    <th width="5%"">
                        {{ trans('cruds.ticket.fields.id') }}
                    </th>
                    <th width="5%">
                        Acciones
                    </th>
                    <th>
                        {{ trans('cruds.ticket.fields.proyecto') }}
                    </th>
                    <th>
                        {{ trans('cruds.ticket.fields.asunto') }}
                    </th>
                    <th>
                        {{ trans('cruds.proyecto.fields.estado') }}
                    </th>
                    <th>
                        Cliente
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<style>
    .btn.btn-xs.btn-info{
        display: none;
    }
</style>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('ticket_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tickets.massDestroy') }}",
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
    ajax: "{{ route('admin.tickets.index') }}",
    columns: [
        { data: 'id', name: 'id' },
        { data: 'actions', name: '{{ trans('global.actions') }}' },
        { data: 'proyecto_nombre_proyecto', name: 'proyecto.nombre_proyecto' },
        { data: 'asunto', name: 'asunto' },
        { data: 'estado', name: 'estado' },
        { data: 'user_name', name: 'user_name' }
    ],
    orderCellsTop: true,
    order: [[ 0, 'desc' ]],
    pageLength: 10,
  };
  let table = $('.datatable-Ticket').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection