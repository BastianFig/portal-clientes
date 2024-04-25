@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.fasecomercialproyecto.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasecomercialproyectos.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $fasecomercialproyecto->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.nota_venta') }}
                                        </th>
                                        <td>
                                            @if ($fasecomercialproyecto->nota_venta)
                                                <a href="{{ $fasecomercialproyecto->nota_venta->getUrl() }}"
                                                    target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.id_proyecto') }}
                                        </th>
                                        <td>
                                            {{ $fasecomercialproyecto->id_proyecto->nombre_proyecto ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.fasecomercialproyecto.fields.estado') }}
                                        </th>
                                        <td>
                                            {{ $fasecomercialproyecto->estado }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.fasecomercialproyectos.index') }}">
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
