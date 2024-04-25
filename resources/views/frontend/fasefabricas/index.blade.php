@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fasefabrica_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fasefabricas.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.fasefabrica.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.fasefabrica.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Fasefabrica">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.aprobacion_course') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.oc_proveedores') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.estado_produccion') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.fecha_entrega') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.galeria_estado_entrega') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.id_proyecto') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.estado') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fasefabricas as $key => $fasefabrica)
                                        <tr data-entry-id="{{ $fasefabrica->id }}">
                                            <td>
                                                {{ $fasefabrica->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\Models\Fasefabrica::APROBACION_COURSE_SELECT[$fasefabrica->aprobacion_course] ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($fasefabrica->oc_proveedores as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ App\Models\Fasefabrica::ESTADO_PRODUCCION_SELECT[$fasefabrica->estado_produccion] ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasefabrica->fecha_entrega ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($fasefabrica->galeria_estado_entrega as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank"
                                                        style="display: inline-block">
                                                        <img src="{{ $media->getUrl('thumb') }}">
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $fasefabrica->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasefabrica->estado ?? '' }}
                                            </td>
                                            <td>
                                                @can('fasefabrica_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fasefabricas.show', $fasefabrica->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fasefabrica_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fasefabricas.edit', $fasefabrica->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fasefabrica_delete')
                                                    <form
                                                        action="{{ route('frontend.fasefabricas.destroy', $fasefabrica->id) }}"
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
            @can('fasefabrica_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fasefabricas.massDestroy') }}",
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
            let table = $('.datatable-Fasefabrica:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
