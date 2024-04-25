@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.fasedespacho.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasedespachos.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $fasedespacho->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.guia_despacho') }}
                                        </th>
                                        <td>
                                            @if ($fasedespacho->guia_despacho)
                                                <a href="{{ $fasedespacho->guia_despacho->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.fecha_despacho') }}
                                        </th>
                                        <td>
                                            {{ $fasedespacho->fecha_despacho }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.estado_instalacion') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Fasedespacho::ESTADO_INSTALACION_SELECT[$fasedespacho->estado_instalacion] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.comentario') }}
                                        </th>
                                        <td>
                                            {!! $fasedespacho->comentario !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.recibe_conforme') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Fasedespacho::RECIBE_CONFORME_SELECT[$fasedespacho->recibe_conforme] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.galeria_estado_muebles') }}
                                        </th>
                                        <td>
                                            @foreach ($fasedespacho->galeria_estado_muebles as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                    style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.id_proyecto') }}
                                        </th>
                                        <td>
                                            {{ $fasedespacho->id_proyecto->nombre_proyecto ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasedespacho.fields.estado') }}
                                        </th>
                                        <td>
                                            {{ $fasedespacho->estado }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasedespachos.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
