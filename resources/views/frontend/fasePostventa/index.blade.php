@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @can('fase_postventum_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-success" href="{{ route('frontend.fase-postventa.create') }}">
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
                        <div class="table-responsive">
                            <table
                                class=" table table-bordered table-striped table-hover datatable datatable-FasePostventum">
                                <thead>
                                    <tr>
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
                                <tbody>
                                    @foreach ($fasePostventa as $key => $fasePostventum)
                                        <tr data-entry-id="{{ $fasePostventum->id }}">
                                            <td>
                                                {{ $fasePostventum->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasePostventum->encuesta->observacion ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasePostventum->ticket->asunto ?? '' }}
                                            </td>
                                            <td>
                                                {{ $fasePostventum->id_proyecto->nombre_proyecto ?? '' }}
                                            </td>
                                            <td>
                                                @foreach ($fasePostventum->id_usuarios as $key => $item)
                                                    <span>{{ $item->name }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{ $fasePostventum->estado ?? '' }}
                                            </td>
                                            <td>
                                                @can('fase_postventum_show')
                                                    <a class="btn btn-xs btn-primary"
                                                        href="{{ route('frontend.fase-postventa.show', $fasePostventum->id) }}">
                                                        {{ trans('global.view') }}
                                                    </a>
                                                @endcan

                                                @can('fase_postventum_edit')
                                                    <a class="btn btn-xs btn-info"
                                                        href="{{ route('frontend.fase-postventa.edit', $fasePostventum->id) }}">
                                                        {{ trans('global.edit') }}
                                                    </a>
                                                @endcan

                                                @can('fase_postventum_delete')
                                                    <form
                                                        action="{{ route('frontend.fase-postventa.destroy', $fasePostventum->id) }}"
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
            @can('fase_postventum_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('frontend.fase-postventa.massDestroy') }}",
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
            let table = $('.datatable-FasePostventum:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })
    </script>
@endsection
