@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.fasefabrica.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasefabricas.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $fasefabrica->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.aprobacion_course') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Fasefabrica::APROBACION_COURSE_SELECT[$fasefabrica->aprobacion_course] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.oc_proveedores') }}
                                        </th>
                                        <td>
                                            @foreach ($fasefabrica->oc_proveedores as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.estado_produccion') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Fasefabrica::ESTADO_PRODUCCION_SELECT[$fasefabrica->estado_produccion] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.fecha_entrega') }}
                                        </th>
                                        <td>
                                            {{ $fasefabrica->fecha_entrega }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.galeria_estado_entrega') }}
                                        </th>
                                        <td>
                                            @foreach ($fasefabrica->galeria_estado_entrega as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank"
                                                    style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.id_proyecto') }}
                                        </th>
                                        <td>
                                            {{ $fasefabrica->id_proyecto->nombre_proyecto ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasefabrica.fields.estado') }}
                                        </th>
                                        <td>
                                            {{ $fasefabrica->estado }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasefabricas.index') }}">
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
