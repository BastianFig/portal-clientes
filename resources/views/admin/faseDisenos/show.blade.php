@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.faseDiseno.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fase-disenos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.id') }}
                        </th>
                        <td>
                            {{ $faseDiseno->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.descripcion') }}
                        </th>
                        <td>
                            {{ $faseDiseno->descripcion }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.imagenes') }}
                        </th>
                        <td>
                            @foreach($faseDiseno->imagenes as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.propuesta') }}
                        </th>
                        <td>
                            @foreach($faseDiseno->propuesta as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.estado') }}
                        </th>
                        <td>
                            {{ $faseDiseno->estado }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.faseDiseno.fields.id_proyecto') }}
                        </th>
                        <td>
                            {{ $faseDiseno->id_proyecto->nombre_proyecto ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fase-disenos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection