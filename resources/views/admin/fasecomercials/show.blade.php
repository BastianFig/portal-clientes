@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fasecomercial.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fasecomercials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.id') }}
                        </th>
                        <td>
                            {{ $fasecomercial->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.comentarios') }}
                        </th>
                        <td>
                            {{ $fasecomercial->comentarios }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.cotizacion') }}
                        </th>
                        <td>
                            @if($fasecomercial->cotizacion)
                                <a href="{{ $fasecomercial->cotizacion->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.oc') }}
                        </th>
                        <td>
                            @if($fasecomercial->oc)
                                <a href="{{ $fasecomercial->oc->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.estado') }}
                        </th>
                        <td>
                            {{ $fasecomercial->estado }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecomercial.fields.id_proyecto') }}
                        </th>
                        <td>
                            {{ $fasecomercial->id_proyecto->nombre_proyecto ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fasecomercials.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection