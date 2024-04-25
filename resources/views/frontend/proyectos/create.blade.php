@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.proyecto.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.proyectos.store') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label class="required"
                                    for="id_cliente_id">{{ trans('cruds.proyecto.fields.id_cliente') }}</label>
                                <select class="form-control select2" name="id_cliente_id" id="id_cliente_id" required>
                                    @foreach ($id_clientes as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('id_cliente_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_cliente'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_cliente') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.id_cliente_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required"
                                    for="id_usuarios_clientes">{{ trans('cruds.proyecto.fields.id_usuarios_cliente') }}</label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-info btn-xs select-all"
                                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                    <span class="btn btn-info btn-xs deselect-all"
                                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                                </div>
                                <select class="form-control select2" name="id_usuarios_clientes[]" id="id_usuarios_clientes"
                                    multiple required>
                                    @foreach ($id_usuarios_clientes as $id => $id_usuarios_cliente)
                                        <option value="{{ $id }}"
                                            {{ in_array($id, old('id_usuarios_clientes', [])) ? 'selected' : '' }}>
                                            {{ $id_usuarios_cliente }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_usuarios_clientes'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_usuarios_clientes') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.proyecto.fields.id_usuarios_cliente_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="sucursal_id">{{ trans('cruds.proyecto.fields.sucursal') }}</label>
                                <select class="form-control select2" name="sucursal_id" id="sucursal_id">
                                    @foreach ($sucursals as $id => $entry)
                                        <option value="{{ $id }}"
                                            {{ old('sucursal_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sucursal'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('sucursal') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.sucursal_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.tipo_proyecto') }}</label>
                                <select class="form-control" name="tipo_proyecto" id="tipo_proyecto">
                                    <option value disabled {{ old('tipo_proyecto', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Proyecto::TIPO_PROYECTO_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('tipo_proyecto', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tipo_proyecto') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.tipo_proyecto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.estado') }}</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Proyecto::ESTADO_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('estado', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('estado'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('estado') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.estado_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.proyecto.fields.fase') }}</label>
                                <select class="form-control" name="fase" id="fase">
                                    <option value disabled {{ old('fase', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Proyecto::FASE_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('fase', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('fase'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('fase') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.fase_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required"
                                    for="nombre_proyecto">{{ trans('cruds.proyecto.fields.nombre_proyecto') }}</label>
                                <input class="form-control input-custom" placeholder="Nombre del proyecto" type="text"
                                    name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto', '') }}"
                                    required style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('nombre_proyecto'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nombre_proyecto') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.proyecto.fields.nombre_proyecto_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="project-img">Imagen del proyecto</label>
                                <input type="file" name="project-img" class="form-control input-custom" style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
