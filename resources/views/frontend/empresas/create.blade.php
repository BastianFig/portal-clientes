@extends('layouts.frontend')
@section('content')
    <div class="col">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        {{ trans('global.create') }} {{ trans('cruds.empresa.title_singular') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('frontend.empresas.store') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-group">
                                <label for="direccion">{{ trans('cruds.empresa.fields.direccion') }}</label>
                                <input class="form-control input-custom" type="text" name="direccion" id="direccion"
                                    value="{{ old('direccion', '') }}"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('direccion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('direccion') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.direccion_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.empresa.fields.comuna') }}</label>
                                <select class="form-control" name="comuna" id="comuna">
                                    <option value disabled {{ old('comuna', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Empresa::COMUNA_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('comuna', 'Seleccionar comuna') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('comuna'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('comuna') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.comuna_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.empresa.fields.region') }}</label>
                                <select class="form-control" name="region" id="region">
                                    <option value disabled {{ old('region', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Empresa::REGION_SELECT as $key => $label)
                                        <option value="{{ $key }}"
                                            {{ old('region', '') === (string) $key ? 'selected' : '' }}>
                                            {{ $label }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('region'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('region') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.region_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required" for="rut">{{ trans('cruds.empresa.fields.rut') }}</label>
                                <input class="form-control input-custom" type="text" name="rut" id="rut"
                                    value="{{ old('rut', '') }}" required
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('rut'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rut') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.rut_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label class="required"
                                    for="razon_social">{{ trans('cruds.empresa.fields.razon_social') }}</label>
                                <input class="form-control input-custom" type="text" name="razon_social"
                                    id="razon_social" value="{{ old('razon_social', '') }}" required
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('razon_social'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('razon_social') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.razon_social_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label
                                    for="nombe_de_fantasia">{{ trans('cruds.empresa.fields.nombe_de_fantasia') }}</label>
                                <input class="form-control  input-custom" type="text" name="nombe_de_fantasia"
                                    id="nombe_de_fantasia" value="{{ old('nombe_de_fantasia', '') }}"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('nombe_de_fantasia'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nombe_de_fantasia') }}
                                    </div>
                                @endif
                                <span
                                    class="help-block">{{ trans('cruds.empresa.fields.nombe_de_fantasia_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="rubro">{{ trans('cruds.empresa.fields.rubro') }}</label>
                                <input class="form-control input-custom" type="text" name="rubro" id="rubro"
                                    value="{{ old('rubro', '') }}"
                                    style="border: none; background-color: #f8f8f8; border-radius: 10px;">
                                @if ($errors->has('rubro'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('rubro') }}
                                    </div>
                                @endif
                                <span class="help-block">{{ trans('cruds.empresa.fields.rubro_helper') }}</span>
                            </div>
                            <div class="form-group">
                                <label>{{ trans('cruds.empresa.fields.estado') }}</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value disabled {{ old('estado', null) === null ? 'selected' : '' }}>
                                        {{ trans('global.pleaseSelect') }}</option>
                                    @foreach (App\Models\Empresa::ESTADO_SELECT as $key => $label)
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
                                <span class="help-block">{{ trans('cruds.empresa.fields.estado_helper') }}</span>
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
