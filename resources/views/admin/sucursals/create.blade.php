@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.sucursal.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sucursals.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="empresa_id">{{ trans('cruds.sucursal.fields.empresa') }}</label>
                <select class="form-control select2 {{ $errors->has('empresa') ? 'is-invalid' : '' }}" name="empresa_id" id="empresa_id" required>
                    @foreach($empresas as $id => $entry)
                        <option value="{{ $id }}" {{ old('empresa_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('empresa'))
                    <div class="invalid-feedback">
                        {{ $errors->first('empresa') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.empresa_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nombre">{{ trans('cruds.sucursal.fields.nombre') }}</label>
                <input class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" type="text" name="nombre" id="nombre" value="{{ old('nombre', '') }}">
                @if($errors->has('nombre'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nombre') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.nombre_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sucursal.fields.region') }}</label>
                <select class="form-control {{ $errors->has('region') ? 'is-invalid' : '' }}" name="region" id="region">
                    <option value="" disabled {{ old('region', '') === null ? 'selected' : '' }}>
                        {{ trans('global.pleaseSelect') }}
                    </option>
                    @foreach(App\Models\Sucursal::REGION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('region', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('region'))
                    <div class="invalid-feedback">
                        {{ $errors->first('region') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.region_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.sucursal.fields.comuna') }}</label>
                <select class="form-control {{ $errors->has('comuna') ? 'is-invalid' : '' }}" name="comuna" id="comuna">
                    <option value disabled {{ old('comuna', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Sucursal::COMUNA_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('comuna', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('comuna'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comuna') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.comuna_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="direccion_sucursal">{{ trans('cruds.sucursal.fields.direccion_sucursal') }}</label>
                <input class="form-control {{ $errors->has('direccion_sucursal') ? 'is-invalid' : '' }}" type="text" name="direccion_sucursal" id="direccion_sucursal" value="{{ old('direccion_sucursal', '') }}">
                @if($errors->has('direccion_sucursal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('direccion_sucursal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.sucursal.fields.direccion_sucursal_helper') }}</span>
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