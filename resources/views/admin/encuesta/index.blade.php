@extends('layouts.admin')
@section('content')

  <div class="card">
    <div class="card-header">
    {{ trans('global.list') }} de Encuestas
    </div>

    <div class="card-body">
    <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Encuestum">
      <thead>
      <tr>
        <th width="5%">
        ID
        </th>
        <th width="5%">
        Acciones
        </th>
        <th>
        Proyecto
        </th>
        <th>
        Empresa
        </th>
        <th>
        Usuario
        </th>
        <th>
        Calificación
        </th>
      </tr>
      </thead>
    </table>
    </div>
  </div>
  <style>
    .btn.btn-xs.btn-info {
    display: none;
    }
  </style>


@endsection
@section('scripts')
  @parent
  <script>
    const _token = '{{ csrf_token() }}';
    $(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
    @can('encuestum_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
    let deleteButton = {
      text: deleteButtonTrans,
      url: "{{ route('admin.encuesta.massDestroy') }}",
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
      headers: { 'x-csrf-token': _token },
      method: 'POST',
      url: config.url,
      data: { ids: ids, _method: 'DELETE' }
      })
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
      ajax: "{{ route('admin.encuesta.index') }}",
      columns: [
      { data: 'placeholder', name: 'id' },
      { data: 'actions', name: 'id' },
      { data: 'nombre_proyecto', name: 'proyecto.nombre_proyecto' },
      { data: 'razon_social', name: 'empresa.razon_social' },
      { data: 'nombre_encuestado', name: 'nombre_encuestado' },
      {
        data: 'rating',
        name: 'rating',
        render: function (data, type, row) {
        // Suponiendo que 'data' es el valor de la calificación, modifica según sea necesario
        var ratingHtml = '<div class="rating">';
        for (var i = 5; i >= 1; i--) {
          var checked = data == i ? 'checked' : '';
          ratingHtml +=
          '<input type="radio" id="star' + i + '" name="rating_' + row.id + '" value="' + i + '" disabled ' + checked + '>' +
          '<label for="star' + i + '" class="star"></label>';
        }
        ratingHtml += '</div>';
        return ratingHtml;
        },
      }
      ],
      orderCellsTop: true,
      order: [[0, 'desc']],
      pageLength: 10,
    };
    let table = $('.datatable-Encuestum').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
      $($.fn.dataTable.tables(true)).DataTable()
      .columns.adjust();
    });

    });

  </script>
@endsection