@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fasecontable.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fasecontables.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.id') }}
                        </th>
                        <td>
                            {{ $fasecontable->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.anticipo_50') }}
                        </th>
                        <td>
                            @if($fasecontable->anticipo_50)
                                <a href="{{ $fasecontable->anticipo_50->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.comentario') }}
                        </th>
                        <td>
                            {{ $fasecontable->comentario }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.anticipo_40') }}
                        </th>
                        <td>
                            @if($fasecontable->anticipo_40)
                                <a href="{{ $fasecontable->anticipo_40->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.anticipo_10') }}
                        </th>
                        <td>
                            @if($fasecontable->anticipo_10)
                                <a href="{{ $fasecontable->anticipo_10->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.id_proyecto') }}
                        </th>
                        <td>
                            {{ $fasecontable->id_proyecto->nombre_proyecto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasecontable.fields.estado') }}
                        </th>
                        <td>
                            {{ $fasecontable->estado }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fasecontables.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection