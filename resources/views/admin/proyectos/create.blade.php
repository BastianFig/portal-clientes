@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.proyecto.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.proyectos.store") }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_vendedor" id="id_vendedor" value="{{$userId}}">

            <div class="form-group">
                <label class="required" for="id_cliente_id">Empresa Cliente</label>
                <select class="form-control select2 {{ $errors->has('id_cliente') ? 'is-invalid' : '' }}"
                    name="id_cliente_id" id="id_cliente_id" required>
                    @foreach($id_clientes as $id => $entry)
                        <option value="{{ $id }}" {{ old('id_cliente_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('id_cliente'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_cliente') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label for="sucursal_id">{{ trans('cruds.proyecto.fields.sucursal') }}</label>
                <select class="form-control select2 {{ $errors->has('sucursal') ? 'is-invalid' : '' }}"
                    name="sucursal_id" id="sucursal_id">
                    <option value="0">Seleccione Sucursal</option>
                </select>
                @if($errors->has('sucursal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sucursal') }}
                    </div>
                @endif
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
                <select class="form-control select2 {{ $errors->has('id_usuarios_clientes') ? 'is-invalid' : '' }}"
                    name="id_usuarios_clientes[]" id="id_usuarios_clientes" multiple required>
                    <option value="0">Seleccione Usuario</option>
                </select>
                @if($errors->has('id_usuarios_clientes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('id_usuarios_clientes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.id_usuarios_cliente_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="orden">Nota de Venta</label>
                <input class="form-control {{ $errors->has('orden') ? 'is-invalid' : '' }}" type="text" name="orden"
                    id="orden" value="{{ old('orden', '') }}">
                @if($errors->has('orden'))
                    <div class="invalid-feedback">
                        {{ $errors->first('orden') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Categoria Proyecto</label>
                <select class="form-control {{ $errors->has('categoria_proyecto') ? 'is-invalid' : '' }}"
                    name="categoria_proyecto" id="categoria_proyecto">
                    <option value disabled {{ old('categoria_proyecto', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Proyecto::CATEGORIA_PROYECTO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('categoria_proyecto', '') === (string) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('categoria_proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('categoria_proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.tipo_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label>Tipo Proyecto</label>
                <select class="form-control {{ $errors->has('tipo_proyecto') ? 'is-invalid' : '' }}"
                    name="tipo_proyecto" id="tipo_proyecto">
                    <option value disabled {{ old('tipo_proyecto', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Proyecto::TIPO_PROYECTO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipo_proyecto', '') === (string) $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('tipo_proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tipo_proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.tipo_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required"
                    for="nombre_proyecto">{{ trans('cruds.proyecto.fields.nombre_proyecto') }}</label>
                <input class="form-control {{ $errors->has('nombre_proyecto') ? 'is-invalid' : '' }}" type="text"
                    name="nombre_proyecto" id="nombre_proyecto" value="{{ old('nombre_proyecto', '') }}" required>
                @if($errors->has('nombre_proyecto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombre_proyecto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.nombre_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label>Estado</label>
                <select class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}" name="estado" id="estado">
                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Proyecto::ESTADO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('estado', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('estado'))
                    <div class="invalid-feedback">
                        {{ $errors->first('estado') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.tipo_proyecto_helper') }}</span>
            </div>
            <div class="form-group">
                <label>Diseñador</label>
                <select class="form-control {{ $errors->has('disenador') ? 'is-invalid' : '' }}" name="disenador"
                    id="disenador">
                    <option value disabled {{ old('disenador', null) === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Proyecto::DISENADOR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('disenador', '') === (string) $key ? 'selected' : '' }}>{{ $label }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('disenador'))
                    <div class="invalid-feedback">
                        {{ $errors->first('disenador') }}
                    </div>
                @endif
            </div>
            <!-- <div class="form-group">
                <label>Instalador</label>
                <select class="form-control {{ $errors->has('instalador') ? 'is-invalid' : '' }}" name="instalador" id="instalador">
                    <option value disabled {{ old('instalador', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Proyecto::INSTALADOR_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('instalador', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('instalador'))
                    <div class="invalid-feedback">
                        {{ $errors->first('instalador') }}
                    </div>
                @endif
            </div>-->
            <div class="form-group d-none">
                <label>{{ trans('cruds.proyecto.fields.fase') }}</label>
                <select class="form-control {{ $errors->has('fase') ? 'is-invalid' : '' }}" name="fase" id="fase">
                    <option value="Fase Diseño">Fase Diseño</option>
                </select>
                @if($errors->has('fase'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fase') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.proyecto.fields.fase_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>

    $('#id_cliente_id').select2();
    $('#sucursal_id').select2();
    $('#id_cliente_id').change(function () {
        var id_empresa = $("#id_cliente_id").val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('admin.users.getSucursales')}}",
            type: "post",
            dataType: 'json',
            data: { id_empresa: id_empresa },
            success: function (response) {
                // console.log(response);
                $("#sucursal_id option").remove();
                $("#id_usuarios_clientes option").remove();
                $("#sucursal_id").append("<option value='0'>Seleccione Sucursal</option>");
                for (let i = 0; i < response.length; i++) {
                    //console.log(response[i].text);
                    $("#sucursal_id").append("<option value='" + response[i].id + "'>" + response[i].text + "</option>");
                }
            },
        });
    });

    $('#sucursal_id').change(function () {

        var id_sucursal = $("#sucursal_id").val();
        //alert(id_sucursal);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('admin.proyectos.getUsuario')}}",
            type: "post",
            dataType: 'json',
            data: { id_sucursal: id_sucursal },
            success: function (response) {
                //console.log(response);
                $("#id_usuarios_clientes option").remove();
                $("#id_usuarios_clientes").append("<option value='0' disabled>Seleccione Usuario</option>");
                for (let i = 0; i < response.length; i++) {
                    //console.log(response[i].text);
                    $("#id_usuarios_clientes").append("<option value='" + response[i].id + "'>" + response[i].text + "</option>");
                }
            },
        });
    });

</script>
@endsection