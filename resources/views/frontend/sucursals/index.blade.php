@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('sucursal_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.sucursals.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.sucursal.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.sucursal.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Sucursal">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.nombre') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.direccion_sucursal') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.comuna') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.region') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.sucursal.fields.empresa') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.empresa.fields.rut') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.empresa.fields.estado') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <input class="search" type="text"
                                                placeholder="{{ trans('global.search') }}">
                                        </td>
                                        <td>
                                            <select class="search" strict="true">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach (App\Models\Sucursal::COMUNA_SELECT as $key => $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="search" strict="true">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach (App\Models\Sucursal::REGION_SELECT as $key => $item)
                                                    <option value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select class="search">
                                                <option value>{{ trans('global.all') }}</option>
                                                @foreach ($empresas as $key => $item)
                                                    <option value="{{ $item->razon_social }}">{{ $item->razon_social }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sucursals as $key => $sucursal)
                                        <tr data-entry-id="{{ $sucursal->id }}">
                                            <td>
                                                {{ $sucursal->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sucursal->nombre ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sucursal->direccion_sucursal ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Sucursal::COMUNA_SELECT[$sucursal->comuna] ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Sucursal::REGION_SELECT[$sucursal->region] ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sucursal->empresa->razon_social ?? '' }}
                                            </td>
                                            <td>
                                                {{ $sucursal->empresa->rut ?? '' }}
                                            </td>
                                            <td>
                                                @if ($sucursal->empresa)
                                                    {{ $sucursal->empresa::ESTADO_SELECT[$sucursal->empresa->estado] ?? '' }}
                                                @endif
                                            </td>
                                            <td>
                                                @can('sucursal_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.sucursals.show', $sucursal->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('sucursal_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.sucursals.edit', $sucursal->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('sucursal_delete')
                                                    <form action="{{ route('frontend.sucursals.destroy', $sucursal->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="submit" class="btn btn-xs btn-danger"
                                                            value="{{ trans('global.delete') }}">
                                                    </form>
                                                @endcan

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('sucursal_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.sucursals.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            let table = $('.datatable-Sucursal:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

            let visibleColumnsIndexes = null;
            $('.datatable thead').on('input', '.search', function() {
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
            table.on('column-visibility.dt', function(e, settings, column, state) {
                visibleColumnsIndexes = []
                table.columns(":visible").every(function(colIdx) {
                    visibleColumnsIndexes.push(colIdx);
                });
            })
        })
    </script>
@endsection
