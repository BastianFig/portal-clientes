@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.empresa.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.empresas.index') }}">
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
                            Antigüedad Empresa
                        </th>
                        <td>
                            {{ $empresa->antiguedad_empresa }}
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
                <a class="btn btn-default" href="{{ route('admin.empresas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#empresa_sucursals" role="tab" data-toggle="tab">
                {{ trans('cruds.sucursal.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#empresa_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#id_cliente_proyectos" role="tab" data-toggle="tab">
                {{ trans('cruds.proyecto.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="empresa_sucursals">
            @includeIf('admin.empresas.relationships.empresaSucursals', ['sucursals' => $empresa->empresaSucursals])
        </div>
        <div class="tab-pane" role="tabpanel" id="empresa_users">
            @includeIf('admin.empresas.relationships.empresaUsers', ['users' => $empresa->empresaUsers])
        </div>
        <div class="tab-pane" role="tabpanel" id="id_cliente_proyectos">
            @includeIf('admin.empresas.relationships.idClienteProyectos', ['proyectos' => $empresa->idClienteProyectos])
        </div>
    </div>
</div>

@endsection