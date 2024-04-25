@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fasecomercialproyecto_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fasecomercialproyectos.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.fasecomercialproyecto.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.fasecomercialproyecto.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class=" table table-bordered table-striped table-hover datatable datatable-Fasecomercialproyecto">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.nota_venta') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.id_proyecto') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.estado') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasecomercialproyectos as $key => $fasecomercialproyecto)
                                        <tr data-entry-id="{{ $fasecomercialproyecto->id }}">
                                            <td>
                                                {{ $fasecomercialproyecto->id ?? '' }}
                                            </td>
                                            <td>
                                                @if ($fasecomercialproyecto->nota_venta)
                                                    <a href="{{ $fasecomercialproyecto->nota_venta->getUrl() }}"
                                                        target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $fasecomercialproyecto->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasecomercialproyecto->estado ?? '' }}
                                            </td>
                                            <td>
                                                @can('fasecomercialproyecto_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fasecomercialproyectos.show', $fasecomercialproyecto->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fasecomercialproyecto_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fasecomercialproyectos.edit', $fasecomercialproyecto->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fasecomercialproyecto_delete')
                                                    <form
                                                        action="{{ route('frontend.fasecomercialproyectos.destroy', $fasecomercialproyecto->id) }}"
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
            @can('fasecomercialproyecto_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fasecomercialproyectos.massDestroy') }}",
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
            let table = $('.datatable-Fasecomercialproyecto:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
