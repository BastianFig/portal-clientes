@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fase_diseno_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fase-disenos.create') }}">
                                {{ trans('global.add') }} {{ trans('cruds.faseDiseno.title_singular') }}
                            </a>
                        </div>
                    </div>
                @endcan
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.faseDiseno.title_singular') }} {{ trans('global.list') }}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-FaseDiseno">
                                <thead>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.descripcion') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.imagenes') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.propuesta') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.estado') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.faseDiseno.fields.id_proyecto') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faseDisenos as $key => $faseDiseno)
                                        <tr data-entry-id="{{ $faseDiseno->id }}">
                                            <td>
                                                {{ $faseDiseno->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $faseDiseno->descripcion ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($faseDiseno->imagenes as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($faseDiseno->propuesta as $key => $media)
                                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $faseDiseno->estado ?? '' }}
                                            </td>
                                            <td>
                                                {{ $faseDiseno->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                @can('fase_diseno_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fase-disenos.show', $faseDiseno->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fase_diseno_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fase-disenos.edit', $faseDiseno->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fase_diseno_delete')
                                                    <form
                                                        action="{{ route('frontend.fase-disenos.destroy', $faseDiseno->id) }}"
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
            @can('fase_diseno_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fase-disenos.massDestroy') }}",
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
            let table = $('.datatable-FaseDiseno:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
