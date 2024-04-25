@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fasePostventum.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fase-postventa.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.id') }}
                        </th>
                        <td>
                            {{ $fasePostventum->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.encuesta') }}
                        </th>
                        <td>
                            {{ $fasePostventum->encuesta->observacion ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.ticket') }}
                        </th>
                        <td>
                            {{ $fasePostventum->ticket->asunto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.id_proyecto') }}
                        </th>
                        <td>
                            {{ $fasePostventum->id_proyecto->nombre_proyecto ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.id_usuario') }}
                        </th>
                        <td>
                            @foreach($fasePostventum->id_usuarios as $key => $id_usuario)
                                <span class="label label-info">{{ $id_usuario->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fasePostventum.fields.estado') }}
                        </th>
                        <td>
                            {{ $fasePostventum->estado }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fase-postventa.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection