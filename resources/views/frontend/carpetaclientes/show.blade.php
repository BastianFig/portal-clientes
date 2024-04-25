@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.carpetacliente.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" style="border-radius: 10px;"
                                    href="{{ route('frontend.carpetaclientes.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $carpetacliente->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.presupuesto') }}
                                        </th>
                                        <td>
                                            @if ($carpetacliente->presupuesto)
                                                <a href="{{ $carpetacliente->presupuesto->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.plano') }}
                                        </th>
                                        <td>
                                            @foreach ($carpetacliente->plano as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.fftt') }}
                                        </th>
                                        <td>
                                            @foreach ($carpetacliente->fftt as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.presentacion') }}
                                        </th>
                                        <td>
                                            @foreach ($carpetacliente->presentacion as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.rectificacion') }}
                                        </th>
                                        <td>
                                            @if ($carpetacliente->rectificacion)
                                                <a href="{{ $carpetacliente->rectificacion->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                   {{-- <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.nb') }}
                                        </th>
                                        <td>
                                            @if ($carpetacliente->nb)
                                                <a href="{{ $carpetacliente->nb->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.course') }}
                                        </th>
                                        <td>
                                            @if ($carpetacliente->course)
                                                <a href="{{ $carpetacliente->course->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>--}}
                                    <tr>
                                        <th>
                                            {{ trans('cruds.carpetacliente.fields.id_fase_comercial') }}
                                        </th>
                                        <td>
                                            {{ $carpetacliente->id_fase_comercial->estado ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.carpetaclientes.index') }}"
                                    style="border-radius: 10px;">
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
