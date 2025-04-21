@extends('layouts.admin')
@section('content')
    @can('empresa_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.empresas.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.empresa.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.empresa.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Empresa">
                <thead>
                    <tr>
                        <th width="5%">
                            {{ trans('cruds.empresa.fields.id') }}
                        </th>
                        <th width="5%">
                            Acciones
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.rut') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.razon_social') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.nombe_de_fantasia') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.rubro') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.region') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.comuna') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.direccion') }}
                        </th>
                        <th>
                            {{ trans('cruds.empresa.fields.estado') }}
                        </th>
                        <th>
                            Tipo Empresa
                        </th>
                    </tr>
                    {{-- <tr>
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
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true" id="busc_region">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Empresa::REGION_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true" id="busc_comu">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Empresa::COMUNA_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true" id="busc_empresa">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Empresa::TIPO_EMPRESA_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                        </td>
                    </tr> --}}
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        const _token = '{{ csrf_token() }}';
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('empresa_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.empresas.massDestroy') }}",
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
                ajax: "{{ route('admin.empresas.index') }}",
                columns: [
                    { data: 'placeholder', name: 'id' },
                    { data: 'actions', name: 'actions' },
                    { data: 'rut', name: 'rut' },
                    { data: 'razon_social', name: 'razon_social' },
                    { data: 'nombe_de_fantasia', name: 'nombe_de_fantasia' },
                    { data: 'rubro', name: 'rubro' },
                    { data: 'region', name: 'region' },
                    { data: 'comuna', name: 'comuna' },
                    { data: 'direccion', name: 'direccion' },
                    { data: 'estado', name: 'estado' },
                    { data: 'tipo_empresa', name: 'tipo_empresa' },
                ],
                orderCellsTop: true,
                order: [[0, 'desc']],
                pageLength: 10,
            };
            let table = $('.datatable-Empresa').DataTable(dtOverrideGlobals);
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