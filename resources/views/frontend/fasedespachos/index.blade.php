@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fasedespacho_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fasedespachos.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.fasedespacho.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.fasedespacho.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Fasedespacho">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.id') }}
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
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasedespachos as $key => $fasedespacho)
                                        <tr data-entry-id="{{ $fasedespacho->id }}">
                                            <td>
                                                {{ $fasedespacho->id ?? '' }}
                                            </td>
                                            <td>
                                                @if ($fasedespacho->guia_despacho)
                                                    <a href="{{ $fasedespacho->guia_despacho->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $fasedespacho->fecha_despacho ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Fasedespacho::ESTADO_INSTALACION_SELECT[$fasedespacho->estado_instalacion] ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Fasedespacho::RECIBE_CONFORME_SELECT[$fasedespacho->recibe_conforme] ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($fasedespacho->galeria_estado_muebles as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank"
                                                        style="display: inline-block">
                                                        <img src="{{ $media->getUrl('thumb') }}">
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $fasedespacho->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasedespacho->estado ?? '' }}
                                            </td>
                                            <td>
                                                @can('fasedespacho_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fasedespachos.show', $fasedespacho->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fasedespacho_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fasedespachos.edit', $fasedespacho->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fasedespacho_delete')
                                                    <form
                                                        action="{{ route('frontend.fasedespachos.destroy', $fasedespacho->id) }}"
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
            @can('fasedespacho_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fasedespachos.massDestroy') }}",
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
            let table = $('.datatable-Fasedespacho:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
