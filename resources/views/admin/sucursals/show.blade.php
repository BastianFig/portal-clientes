@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.sucursal.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sucursals.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.id') }}
                        </th>
                        <td>
                            {{ $sucursal->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.nombre') }}
                        </th>
                        <td>
                            {{ $sucursal->nombre }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.direccion_sucursal') }}
                        </th>
                        <td>
                            {{ $sucursal->direccion_sucursal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.comuna') }}
                        </th>
                        <td>
                            {{ App\Models\Sucursal::COMUNA_SELECT[$sucursal->comuna] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.region') }}
                        </th>
                        <td>
                            {{ App\Models\Sucursal::REGION_SELECT[$sucursal->region] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.sucursal.fields.empresa') }}
                        </th>
                        <td>
                            {{ $sucursal->empresa->razon_social ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sucursals.index') }}">
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
            <a class="nav-link" href="#sucursal_proyectos" role="tab" data-toggle="tab">
                {{ trans('cruds.proyecto.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#sucursal_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="sucursal_proyectos">
            @includeIf('admin.sucursals.relationships.sucursalProyectos', ['proyectos' => $sucursal->sucursalProyectos])
        </div>
        <div class="tab-pane" role="tabpanel" id="sucursal_users">
            @includeIf('admin.sucursals.relationships.sucursalUsers', ['users' => $sucursal->sucursalUsers])
        </div>
    </div>
</div>

@endsection