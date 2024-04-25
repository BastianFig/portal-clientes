@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.show') }} {{ trans('cruds.empresa.title') }}
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.empresas.index') }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.id') }}
                                        </th>
                                        <td>
                                            {{ $empresa->id }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.direccion') }}
                                        </th>
                                        <td>
                                            {{ $empresa->direccion }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.comuna') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Empresa::COMUNA_SELECT[$empresa->comuna] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.region') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Empresa::REGION_SELECT[$empresa->region] ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.rut') }}
                                        </th>
                                        <td>
                                            {{ $empresa->rut }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.razon_social') }}
                                        </th>
                                        <td>
                                            {{ $empresa->razon_social }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.nombe_de_fantasia') }}
                                        </th>
                                        <td>
                                            {{ $empresa->nombe_de_fantasia }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.rubro') }}
                                        </th>
                                        <td>
                                            {{ $empresa->rubro }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ trans('cruds.empresa.fields.estado') }}
                                        </th>
                                        <td>
                                            {{ App\Models\Empresa::ESTADO_SELECT[$empresa->estado] ?? '' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <a class="btn btn-default" href="{{ route('frontend.empresas.index') }}">
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
