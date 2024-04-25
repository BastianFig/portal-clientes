@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fasecontable_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fasecontables.create') }}">
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
                        <div class="table-responsive">
                            <table class=" table table-bordered table-striped table-hover datatable datatable-Fasecontable">
                                <thead>
                                    <tr>
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
                                <tbody>
                                    @foreach ($fasecontables as $key => $fasecontable)
                                        <tr data-entry-id="{{ $fasecontable->id }}">
                                            <td>
                                                {{ $fasecontable->id ?? '' }}
                                            </td>
                                            <td>
                                                @if ($fasecontable->anticipo_50)
                                                    <a href="{{ $fasecontable->anticipo_50->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $fasecontable->comentario ?? '' }}
                                            </td>
                                            <td>
                                                @if ($fasecontable->anticipo_40)
                                                    <a href="{{ $fasecontable->anticipo_40->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($fasecontable->anticipo_10)
                                                    <a href="{{ $fasecontable->anticipo_10->getUrl() }}" target="_blank">
                                                        {{ trans('global.view_file') }}
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $fasecontable->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasecontable->estado ?? '' }}
                                            </td>
                                            <td>
                                                @can('fasecontable_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fasecontables.show', $fasecontable->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fasecontable_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fasecontables.edit', $fasecontable->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fasecontable_delete')
                                                    <form
                                                        action="{{ route('frontend.fasecontables.destroy', $fasecontable->id) }}"
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
            @can('fasecontable_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fasecontables.massDestroy') }}",
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
            let table = $('.datatable-Fasecontable:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
